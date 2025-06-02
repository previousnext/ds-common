<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Button;

use Drupal\Core\Url;

final class ButtonScenarios {

  final public static function button(): \Generator {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Button $instance */
    foreach ([ButtonType::Link, ButtonType::Button] as $type) {
      yield $type->name => Button::create(
        title: 'Link button',
        as: $type,
        href: $type === ButtonType::Link ? $url->toString() : NULL,
      );
    }
  }

}
