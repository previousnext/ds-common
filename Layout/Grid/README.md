# Grid Component

## Sample usage

`Grid` can be treated as a collection:

```php
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Layout as CommonLayouts;

$grid = CommonLayouts\Grid\Grid::create(as: CommonLayouts\Grid\GridType::List);

// Non- GridItem objects appended will get automatically wrapped in a GridItem.
$grid[] = Atom\Html\Html::create(Markup::create('<i>Grid item contents 1</i>'));
$grid[] = $gridItem = CommonLayouts\Grid\GridItem\GridItem::create(
  item: Atom\Html\Html::create(Markup::create('<i>Grid item contents 2</i>')),
  as: CommonLayouts\Grid\GridItem\GridItemType::ListItem,
);

// Class and attributes:
$grid->modifiers[] = GridColumnSizeModifier::ExtraLarge_2;
$grid->containerAttributes['foo'] = 'bar';
$grid->containerAttributes['class'][] = 'hello';
$grid->containerAttributes['class'][] = 'world';
$gridItem->containerAttributes['foo'] = 'bar';
$gridItem->containerAttributes['class'][] = 'hello';
$gridItem->containerAttributes['class'][] = 'world';

$build['Grid'] = $grid();
```
