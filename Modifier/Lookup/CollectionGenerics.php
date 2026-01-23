<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier\Lookup;

use GoodPhp\Reflection;
use GoodPhp\Reflection\Reflector;
use GoodPhp\Reflection\Type\Type;
use Pinto\Attribute\Definition;

/**
 * Discovers which objects are collections, and which data types may be appended or produced when iterated.
 *
 * - Only objects implementing ArrayAccess are recognised.
 * - Generics in PHPDoc are read.
 */
final class CollectionGenerics {

  private static Reflector $reflector;

  /**
   * @var array<class-string<\ArrayAccess<mixed, mixed>>, array{Type|null, Type|null}>
   */
  private array $discovery;

  /**
   * @phpstan-param array<class-string<\Pinto\List\ObjectListInterface>> $pintoLists
   */
  public function __construct(private array $pintoLists) {
    // Build once as it's expensive.
    $this::$reflector ??= (new Reflection\ReflectorBuilder())
      ->withFileCache()
      ->withMemoryCache()
      ->build();
  }

  /**
   * @phpstan-param class-string $objectClass
   * @throws \InvalidArgumentException
   */
  public function iterableType(string $objectClass): Type {
    $this->discovery();

    return $this->discovery[$objectClass][0] ?? throw new \InvalidArgumentException();
  }

  /**
   * @phpstan-param class-string $objectClass
   * @throws \InvalidArgumentException
   */
  public function appendType(string $objectClass): Type {
    $this->discovery();

    return $this->discovery[$objectClass][1] ?? throw new \InvalidArgumentException();
  }

  public function discovery(): void {
    if (isset($this->discovery)) {
      return;
    }

    /** @var array<class-string<\ArrayAccess<mixed, mixed>>> $arrayAccessClasses */
    $arrayAccessClasses = [];

    foreach ($this->pintoLists as $pintoList) {
      foreach ($pintoList::cases() as $case) {
        $rCase = new \ReflectionEnumUnitCase($case::class, $case->name);
        $definitionAttr = ($rCase->getAttributes(Definition::class)[0] ?? NULL)?->newInstance();
        if ($definitionAttr === NULL) {
          continue;
        }

        $rObj = new \ReflectionClass($definitionAttr->className);
        if ($rObj->implementsInterface(\ArrayAccess::class)) {
          /** @var class-string<\ArrayAccess<mixed, mixed>> $objectClassName */
          $objectClassName = $rObj->getName();
          $arrayAccessClasses[] = $objectClassName;
        }
      }
    }

    foreach ($arrayAccessClasses as $objectClassName) {
      $rClass = $this::$reflector->forType($objectClassName);

      $this->discovery[$objectClassName] = [
        $rClass->method('offsetGet')?->returnType(),
        $rClass->method('offsetSet')?->parameter('value')?->type(),
      ];
    }
  }

}
