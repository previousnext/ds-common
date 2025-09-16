<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier\Lookup;

use Pinto\PintoMapping;

final class ModifierLookup {

  /**
   * Map of modifier interfaces to classes implementing the interface.
   *
   * @var array<class-string, array<class-string<\UnitEnum>>>
   */
  private array $enumMap = [];

  /**
   * @phpstan-param array<class-string, array<string, class-string>> $modifierMapping
   */
  public function __construct(
    private PintoMapping $pintoMapping,
    private array $modifierMapping,
  ) {
  }

  /**
   * @phpstan-param class-string $objectClass
   * @phpstan-return string[]
   */
  public function modifiersFor(string $objectClass) {
    // Fix in pinto lib: add reverse method.
    // We actually want the reverse of getCanonicalObjectClassName(), add this hack as a interim solution:
    $r = new \ReflectionClass($this->pintoMapping::class);
    $property = $r->getProperty('lsbFactoryCanonicalObjectClasses');
    $property->setAccessible(TRUE);
    /** @var array<class-string, class-string> $lsbFactoryCanonicalObjectClasses */
    $lsbFactoryCanonicalObjectClasses = $property->getValue($this->pintoMapping);

    $rootObj = \array_search($objectClass, $lsbFactoryCanonicalObjectClasses, TRUE);
    if ($rootObj === FALSE) {
      return [];
    }

    $modifiers = [];
    foreach ($this->modifierMapping[$rootObj] ?? [] as $modifierInterface) {
      \array_push($modifiers, ...\array_values($this->enumMap[$modifierInterface] ?? []));
    }

    return $modifiers;
  }

  /**
   * @phpstan-param class-string $modifierInterface
   * @phpstan-param class-string<\UnitEnum> $modifierClass
   * @internal
   *   May be reworked.
   */
  public function addModifierEnum(string $modifierInterface, $modifierClass): void {
    $this->enumMap[$modifierInterface] ??= [];
    $this->enumMap[$modifierInterface][] = $modifierClass;
  }

}
