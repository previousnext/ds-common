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

}
