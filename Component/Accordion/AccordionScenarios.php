<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Accordion;

final class AccordionScenarios {

  final public static function accordion(): Accordion {
    /** @var Accordion $instance */
    $accordion = (Accordion::create(title: 'Title!')
      ->addSimple('Foo', 'Foo Content')
      ->addSimple('Bar', 'Bar Content')
      ->addSimple('Baz', 'Baz Content')
    );
    $accordion->containerAttributes['hello'] = 'world';
    $accordion->containerAttributes['class'][] = 'foo';
    return $accordion;
  }

}
