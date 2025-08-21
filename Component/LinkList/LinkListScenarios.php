<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\LinkList;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;

final class LinkListScenarios {

  public static function linkList(): LinkList {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $instance = LinkList::create([]);
    $instance[] = Atom\Link\Link::create(title: 'Link!', url: $url);
    $instance[] = Atom\Link\Link::create('Front page!', $url);
    return $instance;
  }

}
