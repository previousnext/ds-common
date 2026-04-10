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

}
