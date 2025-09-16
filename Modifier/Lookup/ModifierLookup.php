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
    $rootObj = $this->pintoMapping->getFactoryOfCanonicalObject($objectClass);
    if (NULL === $rootObj) {
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
