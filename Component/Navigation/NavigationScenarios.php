<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Navigation;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTree;

final class NavigationScenarios {

  final public static function navigation(): Navigation {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Navigation $instance */
    $instance = Navigation::create(
      id: 'sample-id',
      title: 'Title!',
    );

    // Level 1:
    $instance[] = $treeA = MenuTree::create(CommonAtoms\Link\Link::create('Link A', $url));
    $instance[] = $treeB = MenuTree::create(CommonAtoms\Link\Link::create('Link B', $url));
    $instance[] = MenuTree::create(CommonAtoms\Link\Link::create('Link C', $url));

    // Level 2:
    $treeA[] = $treeA1 = MenuTree::create(CommonAtoms\Link\Link::create('Link A1', $url));
    $treeA[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A2', $url));
    $treeA[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A3', $url));
    $treeB[] = MenuTree::create(CommonAtoms\Link\Link::create('Link B1', $url));

    // Level 3.
    $treeA1[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A1a', $url));

    return $instance;
  }

}
