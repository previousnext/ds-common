<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SideNavigation;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTree;

final class SideNavigationScenarios {

  /**
   * @phpstan-return \Generator<SideNavigation>
   */
  final public static function sideNavigation(): \Generator {
    foreach ([TRUE, FALSE] as $hasParentLink) {
      $url = \Mockery::mock(Url::class);
      $url->expects('toString')->andReturn('http://example.com/');

      /** @var SideNavigation $instance */
      $instance = SideNavigation::create(
        id: 'sample-id',
        title: 'Title!',
        parentLink: $hasParentLink ? CommonAtoms\Link\Link::create('Side navigation top link', $url) : NULL,
      );

      // Level 1:
      $instance[] = $treeA = MenuTree::create(CommonAtoms\Link\Link::create('Link A', $url));
      $instance[] = $treeB = MenuTree::create(CommonAtoms\Link\Link::create('Link B', $url));
      $instance[] = MenuTree::create(CommonAtoms\Link\Link::create('Link C', $url));

      // Level 2:
      $treeA[] = $treeA1 = MenuTree::create(CommonAtoms\Link\Link::create('Link A1', $url));
      $treeA[] = $treeA2 = MenuTree::create(CommonAtoms\Link\Link::create('Link A2', $url));
      $treeA[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A3', $url));
      $treeB[] = MenuTree::create(CommonAtoms\Link\Link::create('Link B1', $url));

      // Level 3.
      $treeA1[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A1a', $url));
      $treeA2[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A2a', $url));
      $treeA2[] = MenuTree::create($activeLink = CommonAtoms\Link\Link::create('Link A2b', $url));
      $treeA2[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A2c', $url));

      $instance->setActive($activeLink);

      yield ($hasParentLink ? 'with parent link' : 'without parent link') => $instance;
    }
  }

}
