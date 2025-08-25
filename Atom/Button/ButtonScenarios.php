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

  final public static function buttonStyle(): \Generator {
    foreach (ButtonStyle::cases() as $buttonStyle) {
      $button = Button::create(
        title: 'Button',
        as: ButtonType::Button,
      );
      $button->modifiers[] = $buttonStyle;
      yield $buttonStyle->name => $button;
    }
  }

  final public static function buttonLayout(): \Generator {
    foreach (ButtonLayout::cases() as $buttonLayout) {
      $button = Button::create(
        title: 'Button',
        as: ButtonType::Button,
      );
      $button->modifiers[] = $buttonLayout;
      yield $buttonLayout->name => $button;
    }
  }

}
