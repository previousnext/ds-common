<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs\Tests;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Component\Tabs\Tabs;
use PreviousNext\Ds\Common\List\CommonLists;
use PreviousNext\Ds\Nsw\Lists\NswLists;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;

#[CoversClass(Tabs::class)]
class TabTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();
    $container = new ContainerBuilder();
    $container->setParameter('ids.design_system', 'nsw');
    $container->setParameter('ids.design_system.additional', ['common']);
    $container->setParameter('ids.design_systems', [
      'nsw' => NswLists::Lists,
      'common' => CommonLists::Lists,
    ]);
    IdsContainer::setupContainer($container);
    $container->compile();
  }

  public function testTabs(): void {
    $tabs = Tabs::create('', id: '');
    $tabs[] = CommonComponents\Tabs\Tab::create('', '');
    $tabs[] = $tab2 = CommonComponents\Tabs\Tab::create('', '');
    $tabs[] = CommonComponents\Tabs\Tab::create('', '');
    $tabs->setActive($tab2);

    $rendered = $tabs();
    static::assertFalse($rendered['#listItems'][0]['#active']);
    static::assertTrue($rendered['#listItems'][1]['#active']);
    static::assertFalse($rendered['#listItems'][2]['#active']);
  }

  public function testTabsDoesntExist(): void {
    $tabs = Tabs::create('', id: '');
    $tab = CommonComponents\Tabs\Tab::create('', '');

    static::expectException(\InvalidArgumentException::class);
    static::expectExceptionMessage('Cant set active tab when it does not exist in this tab collection.');
    $tabs->setActive($tab);
  }

  /**
   * Ensure object tracking/state doesn't regress.
   */
  public function testTabsDoesntExistAnymore(): void {
    $tabs = Tabs::create('', id: '');
    $tabs[] = $tab = CommonComponents\Tabs\Tab::create('', '');
    $tabs->setActive($tab);
    $tabs->remove($tab);
    static::expectException(\InvalidArgumentException::class);
    static::expectExceptionMessage('Cant set active tab when it does not exist in this tab collection.');
    $tabs->setActive($tab);
  }

}
