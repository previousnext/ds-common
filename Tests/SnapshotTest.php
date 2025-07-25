<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Tests;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pinto\PintoMapping;
use PreviousNext\Ds\Common\Vo\Id\Id;
use PreviousNext\Ds\Mixtape\Component\HeroBanner\HeroBanner as MixtapeHeroBanner;
use PreviousNext\Ds\Mixtape\List\MixtapeComponents;
use PreviousNext\Ds\Nsw\Component\HeroBanner\HeroBanner as NswHeroBanner;
use PreviousNext\Ds\Nsw\Lists\NswComponents;
use PreviousNext\IdsTools\Command\DumpBuildObjectSnapshots;
use PreviousNext\IdsTools\DependencyInjection\IdsCompilerPass;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;
use PreviousNext\IdsTools\Scenario\CompiledScenario;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

#[CoversMethod(IdsContainer::class, 'testContainers')]
#[CoversMethod(Scenarios::class, 'findScenarios')]
class SnapshotTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();

    // Reset IDs.
    Id::resetGlobalState();
  }

  // @todo we should be able to assert that all objects have N>1 test scenarios

  /**
   * @phpstan-param class-string $objectClassName
   */
  #[CoversNothing]
  #[DataProvider('scenarios')]
  public function testSnapshots(string $ds, CompiledScenario $scenario, object $scenarioObject, string $objectClassName): void {
    IdsContainer::testContainerForDs($ds);

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
    foreach (IdsContainer::testContainers() as $ds => $container) {
      /** @var array<class-string<\Pinto\List\ObjectListInterface>> $primaryLists */
      $primaryLists = $container->getParameter(IdsCompilerPass::PRIMARY_LISTS);

      $pintoMapping = \Drupal::service(PintoMapping::class);
      foreach (Scenarios::findScenarios($pintoMapping, $primaryLists) as $scenario => $scenarioObject) {
        $pintoEnum = $scenario->pintoEnum ?? throw new \LogicException();
        $definition = ((new \ReflectionEnumUnitCase($pintoEnum::class, $pintoEnum->name))->getAttributes(\Pinto\Attribute\Definition::class)[0] ?? NULL)?->newInstance() ?? throw new \LogicException('Missing ' . Definition::class);
        // "for OBJECT" solves when a Scenarios class is used by multiple objects.
        yield \sprintf('Scenario: %s for %s', $scenario, $definition->className) => [$ds, $scenario, $scenarioObject, $definition->className];
      }
    }
  }

  public function testTestContainers(): void {
    $testContainers = \iterator_to_array(IdsContainer::testContainers());
    static::assertEquals([
      'mixtape',
      'nswds',
    ], \array_keys($testContainers));
  }

  /**
   * Sanity test to ensure at least one scenario for each DS is being produced.
   */
  public function testScenarios(): void {
    $designSystems = \array_keys(\iterator_to_array(IdsContainer::testContainers()));
    $designSystems = \Safe\array_combine($designSystems, $designSystems);

    /** @var \Closure(ContainerInterface): array<string, array{\PreviousNext\IdsTools\Scenario\CompiledScenario, callable&object}> $scenariosById */
    $scenariosById = static function (ContainerInterface $container) {
      $pintoMapping = $container->get(PintoMapping::class);
      /** @var array<class-string<\Pinto\List\ObjectListInterface>> $primaryLists */
      $primaryLists = $container->getParameter(IdsCompilerPass::PRIMARY_LISTS);

      /** @var array<string, array{\PreviousNext\IdsTools\Scenario\CompiledScenario, callable&object}> $scenariosById */
      $scenariosById = [];
      foreach (Scenarios::findScenarios($pintoMapping, $primaryLists) as $k => $v) {
        $scenariosById[$k->id] = [$k, $v];
      }
      return $scenariosById;
    };

    // Mixtape.
    $mixtapeScenariosById = $scenariosById(IdsContainer::testContainerForDs($designSystems['mixtape']));
    unset($designSystems['mixtape']);
    static::assertEquals(MixtapeComponents::HeroBanner, $mixtapeScenariosById['heroBanner'][0]->pintoEnum);
    static::assertInstanceOf(MixtapeHeroBanner::class, $mixtapeScenariosById['heroBanner'][1]);

    // NSW.
    $nswScenariosById = $scenariosById(IdsContainer::testContainerForDs($designSystems['nswds']));
    unset($designSystems['nswds']);
    static::assertEquals(NswComponents::HeroBanner, $nswScenariosById['nswHeroBanner'][0]->pintoEnum);
    static::assertInstanceOf(NswHeroBanner::class, $nswScenariosById['nswHeroBanner'][1]);

    // Sanity check to make sure we have tested each DS at least once each.
    static::assertEquals([], $designSystems);
  }

}
