<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom;

final class TabsScenarios {

  public static function tabs(): Tabs {
    /** @var Tabs $instance */
    $instance = Tabs::create('Tabs!', id: 'the-id');
    $instance[] = Tab::create('Tab 1', ['Tab 1 contents!']);
    $instance[] = $tab2 = Tab::create('Tab 2', ['Tab 2 contents!']);
    $instance[] = Tab::create('Tab 3', ['Tab 3 contents!']);
    $instance->addSimple('Tab 4', ['Tab 4 contents!']);
    $instance->setActive($tab2);
    $instance->containerAttributes['foo'] = 'bar';
    return $instance;
  }

  final public static function contentCollection(): Tabs {
    /** @var Tabs $instance */
    $instance = Tabs::create('Tabs!', id: 'the-id');
    $instance[] = $tab = Tab::create('Tab 0', Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 0.</p>
        MARKUP)));
    $tab[] = Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 1.</p>
        MARKUP));
    $tab[] = Atom\Button\Button::create(title: 'Item 2', as: Atom\Button\ButtonType::Link);
    return $instance;
  }

}
