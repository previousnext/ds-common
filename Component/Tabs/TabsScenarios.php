<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs;

final class TabsScenarios {

  public static function tabs(): Tabs {
    /** @var Tabs $instance */
    $instance = Tabs::create('Tabs!', id: 'the-id');
    $instance[] = Tab::create('Tab 1', 'Tab 1 contents!');
    $instance[] = $tab2 = Tab::create('Tab 2', 'Tab 2 contents!');
    $instance[] = Tab::create('Tab 3', 'Tab 3 contents!');
    $instance->addSimple('Tab 4', 'Tab 4 contents!');
    $instance->setActive($tab2);
    $instance->containerAttributes['foo'] = 'bar';
    return $instance;
  }

}
