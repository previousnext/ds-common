<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Tests;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pinto\PintoMapping;
use PreviousNext\Ds\Common\List\CommonLists;
use PreviousNext\Ds\Nsw\Lists\NswLists;
use PreviousNext\IdsTools\Command\DumpBuildObjectSnapshots;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;
use PreviousNext\IdsTools\Scenario\CompiledScenario;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class SnapshotTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();
    $container = new ContainerBuilder();
    // @todo these should be dynamic.
    $container->setParameter('ids.design_system', 'nsw');
    $container->setParameter('ids.design_system.additional', ['common']);
    $container->setParameter('ids.design_systems', [
      'nsw' => NswLists::Lists,
      'common' => CommonLists::Lists,
    ]);
    $container->setParameter('ids.build_objects', [
      'directory' => '/Tests/fixtures/snapshots',
    ]);
    IdsContainer::setupContainer($container);
    $container->compile();
  }

  // @todo we should be able to assert that all objects have N>1 test scenarios

  /**
   * @phpstan-param class-string $objectClassName
   */
  #[CoversNothing]
  #[DataProvider('scenarios')]
  public function testSnapshots(CompiledScenario $scenario, object $scenarioObject, string $objectClassName): void {
    static::assertInstanceOf($objectClassName, $scenarioObject, 'A scenario must return an instance of the object it is attached to.');

    $fs = new Filesystem();
    $serializer = DumpBuildObjectSnapshots::serializerSetup();

    // Get existing snapshot from disk. Use command to regenerate!
    $raw = $fs->readFile(DumpBuildObjectSnapshots::getDiskLocationForScenario($scenario, \Drupal::getContainer()->getParameter('ids.build_objects')['directory']));

    // Get the current snapshot.
    // @todo determine dynamic invoker.
    $rendered = $scenarioObject();

    // Note! Never decode objects and compare decoded vs $rendered, as we do
    // not produce a schema or shape we can reliably restore from. Only compare
    // objects on disk with just-serialised data structures.
    $encoded = $serializer->serialize($rendered, 'yaml', [
      'yaml_flags' => Yaml::DUMP_OBJECT | Yaml::PARSE_CUSTOM_TAGS | Yaml::DUMP_NULL_AS_TILDE | Yaml::PARSE_CONSTANT,
      'yaml_inline' => 100,
      'yaml_indent' => 0,
    ]);

    static::assertEquals($raw, $encoded);
  }

  public static function scenarios(): \Generator {
    $container = new ContainerBuilder();
    $container->setParameter('ids.design_system', 'nsw');
    $container->setParameter('ids.design_system.additional', ['common']);
    $container->setParameter('ids.design_systems', [
      'nsw' => NswLists::Lists,
      'common' => CommonLists::Lists,
    ]);
    IdsContainer::setupContainer($container);
    $container->compile();

    $pintoMapping = \Drupal::service(PintoMapping::class);

    foreach (Scenarios::findScenarios($pintoMapping) as $scenario => $scenarioObject) {
      $pintoEnum = $scenario->pintoEnum ?? throw new \LogicException();
      $definition = ((new \ReflectionEnumUnitCase($pintoEnum::class, $pintoEnum->name))->getAttributes(\Pinto\Attribute\Definition::class)[0] ?? NULL)?->newInstance() ?? throw new \LogicException('Missing ' . Definition::class);
      // "for OBJECT" solves when a Scenarios class is used by multiple objects.
      yield \sprintf('Scenario: %s for %s', $scenario, $definition->className) => [$scenario, $scenarioObject, $definition->className];
    }
  }

}
