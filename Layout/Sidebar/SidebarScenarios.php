<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Sidebar;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom;

final class SidebarScenarios {

  /**
   * @phpstan-return \Generator<Sidebar>
   */
  final public static function sidebar(): \Generator {
    foreach (Position::cases() as $position) {
      /** @var Sidebar $instance */
      $instance = Sidebar::create(
        position: $position,
      );
      $instance[] = Atom\Html\Html::create(Markup::create('<i>Content</i>'));
      $instance->sidebar[] = Atom\Html\Html::create(Markup::create('<i>Sidebar</i>'));

      $instance->containerAttributes->setAttribute('hello', 'world');
      $instance->containerAttributes->addClass('foo');
      $instance->sidebarAttributes->setAttribute('hello', 'sidebar-world');
      $instance->sidebarAttributes->addClass('sidebar-foo');
      $instance->contentAttributes->setAttribute('hello', 'content-world');
      $instance->contentAttributes->addClass('content-foo');
      yield \sprintf('sidebar-%s', $position->name) => $instance;
    }
  }

}
