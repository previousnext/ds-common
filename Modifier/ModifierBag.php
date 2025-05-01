<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier;

use Ramsey\Collection\Set;

/**
 * Represents a collection of enums.
 *
 * - Enums are unique per bag.
 * - There are no unique configuration associated with an enum, other than
 *   the data associated with an enum itself, like methods or attribute data.
 *
 * @template T
 * @extends \Ramsey\Collection\Set<T>
 */
final class ModifierBag extends Set {

  /**
   * @phpstan-param class-string $classString
   */
  public function hasInstanceOf(string $classString): bool {
    foreach ($this as $item) {
      if ($item instanceof $classString) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * @phpstan-param class-string $classString
   * @phpstan-return T|null
   */
  public function getFirstInstanceOf(string $classString) {
    foreach ($this->getInstancesOf($classString) as $item) {
      return $item;
    }

    return NULL;
  }

  /**
   * Get all instances of the class string as a new ModifierBag.
   *
   * @phpstan-param class-string<R> $classString
   * @phpstan-return static<R>
   * @template R of class-string<\PreviousNext\Ds\Common\Component\HeroBanner\HeroBannerModifierInterface>
   */
  public function getInstancesOf(string $classString): ModifierBag {
    /** @var static<R> */
    return $this->filter(function ($item) use ($classString) {
      return $item instanceof $classString;
    });
  }

  public function offsetSet(mixed $offset, mixed $value): void
  {
    if ($value instanceof \UnitEnum) {
      // Is the enum being added mutually exclusive (doesn't allow another enum of the same type to be added in the same ModifierBag instance.
      if ((new \ReflectionClass($value))->getAttributes(Mutex::class, \ReflectionAttribute::IS_INSTANCEOF) !== []) {
        $valueClass = $value::class;
        foreach ($this as $item) {
          if ($item instanceof $valueClass) {
            throw MutexException::create($item, $value);
          }
        }
      }
    }

    parent::offsetSet($offset, $value);
  }

}
