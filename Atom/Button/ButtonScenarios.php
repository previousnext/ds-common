<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Button;

use Drupal\Core\Url;

final class ButtonScenarios {

  final public static function button(): \Generator {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    foreach (ButtonType::cases() as $type) {
      yield $type->name => Button::create(
        title: \sprintf('%s button', $type->name),
        as: $type,
        href: $type === ButtonType::Link ? $url->toString() : NULL,
      );
    }
  }

  final public static function buttonStyle(): \Generator {
    foreach (ButtonStyle::cases() as $buttonStyle) {
      foreach (ButtonType::cases() as $type) {
        $button = Button::create(
          title: \sprintf('%s in style %s', $type->name, $buttonStyle->name),
          as: $type,
        );
        $button->modifiers[] = $buttonStyle;
        yield \sprintf('%s--%s', $buttonStyle->name, $type->name) => $button;
      }
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
