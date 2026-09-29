<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Pinto\PintoMapping;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Layout;
use PreviousNext\Ds\Common\List\CommonLists;
use PreviousNext\Ds\Common\Modifier\Lookup\CollectionGenerics;
use PreviousNext\Ds\Common\Vo;

/**
 * Tests that collection generics are resolved from the PintoMapping lists.
 */
#[CoversClass(CollectionGenerics::class)]
final class CollectionGenericsTest extends TestCase {

  /**
   * @phpstan-param array<class-string<\Pinto\List\ObjectListInterface>>|null $enumClasses
   */
  private static function collectionGenerics(?array $enumClasses = NULL): CollectionGenerics {
    return new CollectionGenerics(new PintoMapping(
      enumClasses: $enumClasses ?? CommonLists::Lists,
      enums: [],
      definitions: [],
      buildInvokers: [],
      types: [],
      lsbFactoryCanonicalObjectClasses: [],
    ));
  }

  /**
   * The type produced when iterating the collection.
   *
   * @phpstan-param class-string $objectClassName
   */
  #[DataProvider('iterableTypeData')]
  public function testIterableType(string $objectClassName, string $expectedType): void {
    static::assertSame($expectedType, (string) static::collectionGenerics()->iterableType($objectClassName));
  }

  /**
   * @phpstan-return \Generator<string, array{class-string, string}>
   */
  public static function iterableTypeData(): \Generator {
    yield 'html is untyped' => [Atom\Html\Html::class, 'mixed'];
    yield 'accordion yields items' => [Component\Accordion\Accordion::class, Component\Accordion\AccordionItem\AccordionItem::class];
    yield 'breadcrumb yields links' => [Component\Breadcrumb\Breadcrumb::class, Atom\Link\Link::class];
    yield 'link list yields links' => [Component\LinkList\LinkList::class, Atom\Link\Link::class];
    yield 'navigation yields menu trees' => [Component\Navigation\Navigation::class, Vo\MenuTree\MenuTree::class];
    yield 'steps yields steps' => [Component\Steps\Steps::class, Component\Steps\Step\Step::class];
    yield 'grid yields grid items' => [Layout\Grid\Grid::class, Layout\Grid\GridItem\GridItem::class];
    yield 'section yields section items' => [Layout\Section\Section::class, Layout\Section\SectionItem::class];
    yield 'sidebar is untyped' => [Layout\Sidebar\Sidebar::class, 'mixed'];
  }

  /**
   * The type required when appending to the collection.
   *
   * @phpstan-param class-string $objectClassName
   */
  #[DataProvider('appendTypeData')]
  public function testAppendType(string $objectClassName, string $expectedType): void {
    static::assertSame($expectedType, (string) static::collectionGenerics()->appendType($objectClassName));
  }

  /**
   * @phpstan-return \Generator<string, array{class-string, string}>
   */
  public static function appendTypeData(): \Generator {
    yield 'html accepts anything' => [Atom\Html\Html::class, 'mixed'];
    yield 'accordion accepts anything' => [Component\Accordion\Accordion::class, 'mixed'];
    yield 'breadcrumb accepts links' => [Component\Breadcrumb\Breadcrumb::class, Atom\Link\Link::class];
    yield 'link list accepts links' => [Component\LinkList\LinkList::class, Atom\Link\Link::class];
    yield 'navigation accepts menu trees' => [Component\Navigation\Navigation::class, Vo\MenuTree\MenuTree::class];
    yield 'steps accepts anything' => [Component\Steps\Steps::class, 'mixed'];
    yield 'grid accepts anything' => [Layout\Grid\Grid::class, 'mixed'];
    yield 'section accepts anything' => [Layout\Section\Section::class, 'mixed'];
    yield 'sidebar accepts anything' => [Layout\Sidebar\Sidebar::class, 'mixed'];
  }

}
