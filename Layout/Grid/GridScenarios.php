<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Mixtape\Layout\Grid\GridColumnSizeModifier;
use PreviousNext\IdsTools\Scenario\Scenario;

final class GridScenarios {

  final public static function grid(): Grid {
    /** @var Grid $instance */
    $instance = Grid::create(as: GridType::List, gridItemDefaultType: GridItem\GridItemType::ListItem);
    $instance[] = Atom\Html\Html::create(Markup::create('<i>Grid item contents 1</i>'));
    $instance[] = $gridItem = GridItem\GridItem::create(
      item: Atom\Html\Html::create(Markup::create('<i>Grid item contents 2</i>')),
      as: GridItem\GridItemType::Div,
    );
    $gridItem->containerAttributes['foo'] = 'gibar';
    $gridItem->containerAttributes['class'][] = 'gi hello';
    $gridItem->containerAttributes['class'][] = 'gi world';

    return $instance;
  }

  #[Scenario(viewPortWidth: 1000, viewPortHeight: 800)]
  final public static function cardGrid(): \Generator {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    foreach ([
       [\PreviousNext\Ds\Nsw\Layout\Grid\GridColumnSizeModifier::ExtraLarge2, 2],
       [\PreviousNext\Ds\Nsw\Layout\Grid\GridColumnSizeModifier::Large3, 3],
       [\PreviousNext\Ds\Nsw\Layout\Grid\GridColumnSizeModifier::Medium4, 4],
       [\PreviousNext\Ds\Nsw\Layout\Grid\GridColumnSizeModifier::Medium3, 3],
       [\PreviousNext\Ds\Nsw\Layout\Grid\GridColumnSizeModifier::Medium3, 6],
    ] as [$gridColumnSizeModifier, $cardQuantity]) {
      /** @var static $instance */
      $instance = Grid::create(as:GridType::Div, gridItemDefaultType: GridItem\GridItemType::Div);
      if (\class_exists(\PreviousNext\Ds\Nsw\Layout\Grid\GridColumnSizeModifier::class)) {
        $instance->modifiers[] = $gridColumnSizeModifier;
      }
      elseif (\class_exists(GridColumnSizeModifier::class)) {
        $instance->modifiers[] = GridColumnSizeModifier::Medium3;
      }

      for ($i = 0; $i < $cardQuantity; $i++) {
        $instance[] = Component\Card\Card::create(
          image: Component\Media\Image\Image::createSample(558, 418),
          links: Component\LinkList\LinkList::create([
            Atom\Link\Link::create(title: 'zz', url: $url),
          ]),
          date: new \DateTimeImmutable('1st January 2001'),
          content: Atom\Html\Html::create(Markup::create(<<<MARKUP
            <p>
              Ut ad venenatis habitasse parturient parturient etiam ridiculus at ullamcorper condimentum in phasellus nisi dis a.
            </p>
            MARKUP)),
          link: Atom\Link\Link::create(title: 'Card Link!', url: $url),
        // modifiers: [Component\Card\CommonCardModifiers::Modifier1],.
        )();
      }

      yield \sprintf('%sx%s', $gridColumnSizeModifier->name, $cardQuantity) => $instance;
    }
  }

}
