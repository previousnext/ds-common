<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Callout;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom as CommonAtoms;

final class CalloutScenarios {

  final public static function callout(): Callout {
    /** @var Callout $instance */
    $instance = Callout::create(
      CommonAtoms\Heading\Heading::create('Heading!', \PreviousNext\Ds\Common\Atom\Heading\HeadingLevel::Two),
      CommonAtoms\Html\Html::create(Markup::create('<div>Foo <strong>bar</strong></div>')),
    );
    $instance->containerAttributes['foo'] = 'bar';
    $instance->containerAttributes['class'][] = 'hello';
    $instance->containerAttributes['class'][] = 'world';
    return $instance;
  }

  final public static function contentCollection(): Callout {
    $instance = Callout::create(
      heading: CommonAtoms\Heading\Heading::create('Heading!', \PreviousNext\Ds\Common\Atom\Heading\HeadingLevel::Two),
      content: CommonAtoms\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 0.</p>
        MARKUP)),
    );
    $instance[] = CommonAtoms\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 1.</p>
        MARKUP));
    $instance[] = CommonAtoms\Button\Button::create(title: 'Item 2', as: CommonAtoms\Button\ButtonType::Link);
    return $instance;
  }

}
