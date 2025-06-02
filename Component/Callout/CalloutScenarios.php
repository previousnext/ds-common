<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Callout;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom as CommonAtoms;

final class CalloutScenarios {

  final public static function callout(): Callout {
    /** @var Callout $instance */
    $instance = Callout::create(
      CommonAtoms\Heading\Heading::create('Heading!'),
      CommonAtoms\Html\Html::create(Markup::create('<div>Foo <strong>bar</strong></div>')),
    );
    $instance->containerAttributes['foo'] = 'bar';
    $instance->containerAttributes['class'][] = 'hello';
    $instance->containerAttributes['class'][] = 'world';
    return $instance;
  }

}
