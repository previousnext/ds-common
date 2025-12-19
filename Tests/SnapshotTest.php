<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Tests;

use Drupal\pinto\Build\BuildRegistryInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pinto\PintoMapping;
use PreviousNext\Ds\Common\Vo\Id\Id;
use PreviousNext\IdsTools\Command\DumpBuildObjectSnapshots;
use PreviousNext\IdsTools\DependencyInjection\IdsCompilerPass;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;
use PreviousNext\IdsTools\Rendering\ComponentRender;
use PreviousNext\IdsTools\Scenario\CompiledScenario;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class SnapshotTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();

    // Reset IDs.
    Id::resetGlobalState();
  }

  /**
   * Tests scenarios complete, also adds coverage data.
   */
  #[DataProvider('containers')]
  public function testScenarioGeneration(ContainerInterface $container): void {
    \Drupal::setContainer($container);

    /** @var \PreviousNext\IdsTools\Command\DumpBuildObjectSnapshots $command */
    $command = $container->get(DumpBuildObjectSnapshots::class);
    $commandTester = new CommandTester($command);
    static::assertEquals(Command::SUCCESS, $commandTester->execute([
      // Set dry run otherwise all fixtures will be written to disk and subsequent `testSnapshots` test will fail
      // erroneously.
      '--dry-run' => TRUE,
    ]));
    static::assertStringContainsString('This is a dry run.', $commandTester->getDisplay(TRUE));
  }

  public static function containers(): \Generator {
    foreach (IdsContainer::testContainers() as $ds => $container) {
      yield $ds => [$container];
    }
  }

  /**
   * @phpstan-param class-string $objectClassName
   * @phpstan-param array<mixed> $rendered
   */
  #[DataProvider('scenarios')]
  public function testSnapshots(
    string $ds,
    CompiledScenario $scenario,
    object $scenarioObject,
    string $objectClassName,
    array $rendered,
  ): void {
    IdsContainer::testContainerForDs($ds);

    static::assertInstanceOf($objectClassName, $scenarioObject, 'A scenario must return an instance of the object it is attached to.');

    $fs = new Filesystem();
    $serializer = DumpBuildObjectSnapshots::serializerSetup();

    // Get existing snapshot from disk. Use command to regenerate!
    $raw = $fs->readFile(DumpBuildObjectSnapshots::getDiskLocationForScenario($scenario, \Drupal::getContainer()->getParameter('ids.build_objects')['directory']));

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
    foreach (IdsContainer::testContainers() as $ds => $container) {
      $buildRegistry = $container->get(BuildRegistryInterface::class);

      /** @var array<class-string<\Pinto\List\ObjectListInterface>> $primaryLists */
      $primaryLists = $container->getParameter(IdsCompilerPass::PRIMARY_LISTS);

      $pintoMapping = \Drupal::service(PintoMapping::class);
      foreach (Scenarios::findScenarios($pintoMapping, $primaryLists) as $scenario => $scenarioObject) {
        // Reset IDs.
        Id::resetGlobalState();

        // Get the current snapshot.
        $rendered = ComponentRender::render($pintoMapping, $buildRegistry, $scenarioObject);

        $pintoEnum = $scenario->pintoEnum ?? throw new \LogicException();
        $definition = ((new \ReflectionEnumUnitCase($pintoEnum::class, $pintoEnum->name))->getAttributes(\Pinto\Attribute\Definition::class)[0] ?? NULL)?->newInstance() ?? throw new \LogicException('Missing ' . Definition::class);
        // "for OBJECT" solves when a Scenarios class is used by multiple objects.
        yield \sprintf('Scenario: %s for %s', $scenario, $definition->className) => [
          $ds,
          $scenario,
          $scenarioObject,
          $definition->className,
          $rendered,
        ];
      }
    }
  }

}
