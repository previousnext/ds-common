<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier\Lookup;

use GoodPhp\Reflection;
use GoodPhp\Reflection\Reflector;
use GoodPhp\Reflection\Type\NamedType;
use Pinto\Attribute\Definition;
use PreviousNext\Ds\Common\Modifier\ModifierBag;

/**
 * Discovers the type of modifiers each object can take in its modifier bag.
 *
 * - An object can have zero or multiple modifier bags.
 * - Modifier bags are public properties on an object implementing ModifierBag.
 * - Generics are set using PHPDoc, and ModifierBag construction, determining what are valid items.
 */
final class ModifierBagTypeDiscovery {

  private static Reflector $reflector;

  public function __construct() {
    // Build once as it's expensive.
    $this::$reflector ??= (new Reflection\ReflectorBuilder())
      ->withFileCache()
      ->withMemoryCache()
      ->build();
  }

  /**
   * @phpstan-param array<class-string<\Pinto\List\ObjectListInterface>>  $pintoLists
   * @phpstan-return array<class-string, array<string, class-string>>
   */
  public function discovery(array $pintoLists): array {
    // Mapping pinto obj to modifier bag property name(s)
    /** @var array<class-string, string[]> $objectModifierProperties */
    $objectModifierProperties = [];

    foreach ($pintoLists as $pintoList) {
      foreach ($pintoList::cases() as $case) {
        $rCase = new \ReflectionEnumUnitCase($case::class, $case->name);
        $definitionAttr = ($rCase->getAttributes(Definition::class)[0] ?? NULL)?->newInstance();
        if ($definitionAttr === NULL) {
          continue;
        }

        $rObj = new \ReflectionClass($definitionAttr->className);
        foreach ($rObj->getProperties(\ReflectionProperty::IS_PUBLIC) as $rProperty) {
          $propertyType = $rProperty->getType();
          if ($propertyType instanceof \ReflectionNamedType && \class_exists($propertyType->getName())) {
            $rModifierClass = new \ReflectionClass($propertyType->getName());
            if ($rModifierClass->isSubclassOf(ModifierBag::class) || $rModifierClass->getName() === ModifierBag::class) {
              $objectModifierProperties[$rObj->getName()] ??= [];
              $objectModifierProperties[$rObj->getName()][] = $rProperty->getName();
            }
          }
        }
      }
    }

    /** @var array<class-string, array<string, class-string>> $objectModifierTemplates */
    $objectModifierTemplates = [];

    foreach ($objectModifierProperties as $objClassName => $modifierBagProperties) {
      $reflectClass = $this::$reflector->forType($objClassName);
      \assert($reflectClass instanceof Reflection\NativePHPDoc\Reflection\NpdClassReflection);
      foreach ($modifierBagProperties as $propertyName) {
        $reflectProperty = $reflectClass->property($propertyName);
        \assert($reflectProperty instanceof Reflection\NativePHPDoc\Reflection\NpdPropertyReflection);
        $propertyType = $reflectProperty->type() ?? throw new \LogicException('Should never happen?');
        \assert($propertyType instanceof NamedType);

        // Already checked above.
        \assert($propertyType->name === ModifierBag::class);

        // We really can't be sure if this will be right, so sanity check interface and move on.
        $arg0 = $propertyType->arguments[0];
        if (!$arg0 instanceof NamedType) {
          throw new \LogicException('Unhandled....');
        }

        $templateType = $arg0->name;
        if (FALSE === \interface_exists($templateType)) {
          throw new \LogicException(\sprintf('Unable to determine template for %s->$%s', $objClassName, $propertyName));
        }

        $objectModifierTemplates[$objClassName][$propertyName] = $templateType;
      }
    }

    return $objectModifierTemplates;
  }

}
