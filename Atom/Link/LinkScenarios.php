<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Url;

final class LinkScenarios {

  final public static function link(): Link {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');
    return Link::create('Example', $url);
  }

  final public static function linkMore(): Link {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');
    return Link::create('Example', $url, more: TRUE);
  }

  final public static function linkExternal(): Link {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');
    return Link::create('Example', $url, external: TRUE);
  }

  final public static function linkDownload(): Link {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');
    return Link::create('Example', $url, download: TRUE);
  }

}
