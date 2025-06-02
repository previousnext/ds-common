<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\HeroBanner;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;

final class HeroBannerScenarios {

  final public static function heroBanner(): HeroBanner {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var HeroBanner $instance */
    $instance = HeroBanner::create(
      'Title!',
      'Subtitle!',
      image: Component\Media\Image\Image::createSample(600, 200),
    );
    // Todo test modifiers on base class.
    return $instance;
  }

  final public static function heroBannerLinkList(): HeroBanner {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var HeroBanner $instance */
    $instance = HeroBanner::create(
      'Hero Link List Title!',
      'Hero Link List Subtitle!',
      link: Atom\Link\Link::create('Hero Banner Link!', $url),
      links: Component\LinkList\LinkList::create([
        Atom\Link\Link::create(title: '', url: $url),
        Atom\Link\Link::create('Front page!', $url),
        Atom\Link\Link::create('Hero Link List item 2!', $url),
      ]),
    );
    // Todo test modifiers on base class.
    return $instance;
  }

}
