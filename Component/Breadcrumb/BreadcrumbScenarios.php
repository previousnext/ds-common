<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Breadcrumb;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom\Link\Link;

final class BreadcrumbScenarios {

  final public static function breadcrumb(): Breadcrumb {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Breadcrumb $instance */
    $instance = Breadcrumb::create();
    $instance[] = Link::create('Link 1', $url);
    $instance[] = Link::create('Link 2', $url);
    $instance[] = Link::create('Link 3', $url);
    $instance->containerAttributes['hello'] = 'world';
    $instance->containerAttributes['class'][] = 'foo';
    $instance->containerAttributes['name'] = 'world';
    return $instance;
  }

}
