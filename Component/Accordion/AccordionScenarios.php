<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Accordion;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom;

final class AccordionScenarios {

  final public static function accordion(): Accordion {
    /** @var Accordion $instance */
    $accordion = (Accordion::create(title: Atom\Heading\Heading::create('Title!', Atom\Heading\HeadingLevel::Two))
      ->addSimple('Foo', Atom\Html\Html::create(Markup::create('<p>Foo Content</p>')))
      ->addSimple('Bar', Atom\Html\Html::create(Markup::create('<p>Bar Content</p>')))
      ->addSimple('Baz', Atom\Html\Html::create(Markup::create('<p>Baz Content</p>')))
    );
    $accordion->containerAttributes['hello'] = 'world';
    $accordion->containerAttributes['class'][] = 'foo';
    return $accordion;
  }

  final public static function contentCollection(): Accordion {
    $instance = Accordion::create(title: Atom\Heading\Heading::create('Title!', Atom\Heading\HeadingLevel::Two));
    $instance[] = $accordionItem = AccordionItem\AccordionItem::create('Foo', Atom\Html\Html::create(Markup::create('<p>Foo Content</p>')));
    $accordionItem[] = Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 1.</p>
        MARKUP));
    $accordionItem[] = Atom\Button\Button::create(title: 'Item 2', as: Atom\Button\ButtonType::Link);
    return $instance;
  }

}
