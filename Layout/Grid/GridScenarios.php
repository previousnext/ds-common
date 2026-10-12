<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom;

final class GridScenarios {

  final public static function grid(): Grid {
    /** @var Grid $instance */
    $instance = Grid::create(as: GridType::List, gridItemDefaultType: GridItem\GridItemType::ListItem);
    $instance[] = Atom\Html\Html::create(Markup::create('<i>Grid item contents 1</i>'));
    $instance[] = $gridItem = GridItem\GridItem::create(
      as: GridItem\GridItemType::Div,
    );
    $gridItem[] = Atom\Html\Html::create(Markup::create('<i>Grid item contents 2</i>'));
    $gridItem->containerAttributes->setAttribute('foo', 'gibar');
    $gridItem->containerAttributes->addClass('gi hello');
    $gridItem->containerAttributes->addClass('gi world');

    return $instance;
  }

  /**
   * @phpstan-return \Generator<Grid>
   */
  final public static function gridItemsContained(): \Generator {
    foreach ([TRUE, FALSE] as $isContainer) {
      /** @var Grid $grid */
      $grid = Grid::create(as: GridType::Div, gridItemDefaultType: GridItem\GridItemType::ListItem);
      foreach (\range(1, 3) as $i) {
        $grid[] = $gridItem = GridItem\GridItem::create(
          as: GridItem\GridItemType::Div,
          isContainer: $isContainer,
        );
        $gridItem[] = Atom\Html\Html::create(Markup::create(\sprintf('<i>Grid item contents %s</i>', $i)));
      }
      yield 'grid items are ' . (!$isContainer ? 'not' : '') . ' contained' => $grid;
    }
  }

}
