<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Pagination;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Component as CommonComponent;

final class PaginationScenarios {

  final public static function pagination(): Pagination {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $previousIcon = CommonAtoms\Icon\Icon::create('arrow-left');
    $nextIcon = CommonAtoms\Icon\Icon::create('arrow-right');

    /** @var Pagination $instance */
    $instance = Pagination::create(
    // @todo there should be some kind of helper to make this easier:
      previous: CommonAtoms\Link\Link::create('Previous', $url, iconStart: $previousIcon),
      next: CommonAtoms\Link\Link::create('Next', $url, iconEnd: $nextIcon),
    );
    $instance->containerAttributes['hello'] = 'world';
    $instance->containerAttributes['class'][] = 'foo';

    // @todo there should be some kind of helper to make this easier:
    $instance[] = CommonComponent\Pagination\PaginationItem\PaginationItem::create(link: CommonAtoms\Link\Link::create('1', $url));
    $instance[] = $page2 = CommonComponent\Pagination\PaginationItem\PaginationItem::create(link: CommonAtoms\Link\Link::create('2', $url));
    $instance[] = CommonComponent\Pagination\PaginationItem\PaginationItem::create(ellipsis: TRUE);
    $instance[] = CommonComponent\Pagination\PaginationItem\PaginationItem::create(link: CommonAtoms\Link\Link::create('99', $url));
    $instance[] = CommonComponent\Pagination\PaginationItem\PaginationItem::create(link: CommonAtoms\Link\Link::create('100', $url));
    $instance->setActivePage($page2);
    return $instance;
  }

}
