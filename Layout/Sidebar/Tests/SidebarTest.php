<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Sidebar\Tests;

use PHPUnit\Framework\TestCase;
use PreviousNext\Ds\Common\Layout as CommonLayouts;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;

class SidebarTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();

    IdsContainer::testContainerForDs('mixtape');
  }

  public function testSidebarDisconnectionOnClone(): void {
    $sidebarLayout = CommonLayouts\Sidebar\Sidebar::create(CommonLayouts\Sidebar\Position::Start);
    $sidebarLayout->containerAttributes->addClass('ct');
    $sidebarLayout->contentAttributes->addClass('con');
    $sidebarLayout[] = 'Content';
    $sidebarLayout->sidebar[] = 'Sidebar';
    static::assertCount(1, $sidebarLayout);
    static::assertCount(1, $sidebarLayout->sidebar);

    $sidebarLayout->sidebarAttributes->addClass('class1');
    $sidebarLayout->sidebar->sidebarAttributes->addClass('class2');
    static::assertEquals('class1 class2', (string) $sidebarLayout->sidebarAttributes->getClass());
    static::assertEquals('class1 class2', (string) $sidebarLayout->sidebar->sidebarAttributes->getClass());
    static::assertCount(2, $sidebarLayout->sidebarAttributes['class']);
    static::assertCount(2, $sidebarLayout->sidebar->sidebarAttributes['class']);

    $cloned = clone $sidebarLayout;
    $cloned[] = 'Content 2';
    $cloned->sidebar[] = 'Sidebar 2';
    // Original is untouched:
    static::assertCount(1, $sidebarLayout);
    static::assertCount(1, $sidebarLayout->sidebar);
    // Clone has original and more:
    static::assertCount(2, $cloned);
    static::assertCount(2, $cloned->sidebar);

    $cloned->containerAttributes->addClass('ct');
    $cloned->contentAttributes->addClass('con');
    $cloned->sidebarAttributes->addClass('class1');
    $cloned->sidebar->sidebarAttributes->addClass('class2');
    // Original is untouched:
    static::assertCount(2, $sidebarLayout->sidebarAttributes['class']);
    static::assertCount(2, $sidebarLayout->sidebar->sidebarAttributes['class']);
    // Clone has original and more:
    static::assertCount(2, $cloned->containerAttributes['class']);
    static::assertCount(2, $cloned->contentAttributes['class']);
    static::assertCount(4, $cloned->sidebarAttributes['class']);
    static::assertCount(4, $cloned->sidebar->sidebarAttributes['class']);
  }

}
