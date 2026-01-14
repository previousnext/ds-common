<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\HeroBanner;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\IdsTools\Scenario\Scenario;

final class HeroBannerScenarios {

  final public static function heroBanner(): HeroBanner {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroBanner::create(
      title: 'Title!',
      subtitle: 'Subtitle!',
      image: CommonComponents\Media\Image\Image::createSample(600, 200),
    );
  }

  final public static function heroBannerLink(): HeroBanner {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroBanner::create(
      title: 'Hero Link List Title!',
      link: Atom\Link\Link::create('Hero Banner Link!', $url),
    );
  }

  final public static function heroBannerButton(): HeroBanner {
    return HeroBanner::create(
      title: 'Hero Link List Title!',
      link: Atom\Button\Button::create('Hero Banner Button!', as: Atom\Button\ButtonType::Link, href: 'http://example.com/'),
    );
  }

  final public static function heroBannerLinkList(): HeroBanner {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroBanner::create(
      title: 'Hero Link List Title!',
      subtitle: 'Hero Link List Subtitle!',
      links: CommonComponents\LinkList\LinkList::create([
        Atom\Link\Link::create(title: 'A link', url: $url),
        Atom\Link\Link::create('Front page!', $url),
        Atom\Link\Link::create('Hero Link List item 2!', $url),
      ]),
    );
  }

  final public static function heroBannerHighlighted(): HeroBanner {
    $instance = HeroBanner::create(
      title: 'Title!',
      image: CommonComponents\Media\Image\Image::createSample(600, 200),
    );
    $instance->highlight = TRUE;
    return $instance;
  }

  #[Scenario(viewPortWidth: 1200, viewPortHeight: 300)]
  final public static function heroBannerContent(): HeroBanner {
    $instance = HeroBanner::create(
      title: 'Title!',
      image: CommonComponents\Media\Image\Image::createSample(600, 200),
    );
    $instance[] = Atom\Html\Html::create(Markup::create(<<<HTML
      <p>
        1st February 2026
        <br />
        <strong>Santa Claus</strong>
      </p>
      HTML));
    $instance[] = $tags = CommonComponents\Tags\Tags::create();
    $tags[] = CommonComponents\Tags\Tag::create('Tag 1');
    $tags[] = CommonComponents\Tags\Tag::create('Tag 2');
    return $instance;
  }

}
