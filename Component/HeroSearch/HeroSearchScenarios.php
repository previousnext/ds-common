<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\HeroSearch;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\IdsTools\Scenario\Scenario;

final class HeroSearchScenarios {

  #[Scenario(viewPortWidth: 1000, viewPortHeight: 300)]
  final public static function heroSearchForm(): HeroSearch {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroSearch::create(
      title: 'Hero Link List Title!',
      subtitle: 'Hero Link List Subtitle!',
      image: CommonComponents\Media\Image\Image::createSample(800, 600),
      links: CommonComponents\LinkList\LinkList::create([
        Atom\Link\Link::create(title: 'Link 1!', url: $url),
        Atom\Link\Link::create(title: 'Link 2!', url: $url),
        Atom\Link\Link::create(title: 'Link 3!', url: $url),
        Atom\Link\Link::create(title: 'Link 4!', url: $url),
        Atom\Link\Link::create(title: 'Link 5!', url: $url),
      ]),
      searchFormOrActionUrl: CommonComponents\SearchForm\SearchForm::create(actionUrl: 'https://example.com/search'),
    );
  }

  #[Scenario(viewPortWidth: 1000, viewPortHeight: 300)]
  final public static function heroSearchLinkList(): HeroSearch {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroSearch::create(
      title: 'Hero Link List Title!',
      subtitle: 'Hero Link List Subtitle!',
      links: CommonComponents\LinkList\LinkList::create([
        Atom\Link\Link::create(title: 'Link 1!', url: $url),
        Atom\Link\Link::create(title: 'Link 2!', url: $url),
        Atom\Link\Link::create(title: 'Link 3!', url: $url),
        Atom\Link\Link::create(title: 'Link 4!', url: $url),
        Atom\Link\Link::create(title: 'Link 5!', url: $url),
      ]),
    );
  }

  #[Scenario(viewPortWidth: 1000, viewPortHeight: 300)]
  final public static function heroSearchFormAndImage(): HeroSearch {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroSearch::create(
      title: 'Title!',
      subtitle: 'Subtitle!',
      image: CommonComponents\Media\Image\Image::createSample(800, 600),
      searchFormOrActionUrl: CommonComponents\SearchForm\SearchForm::create(actionUrl: 'https://example.com/search'),
    );
  }

  #[Scenario(viewPortWidth: 1000, viewPortHeight: 300)]
  final public static function heroSearchFormAndLinks(): HeroSearch {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return HeroSearch::create(
      title: 'Hero Link List Title!',
      subtitle: 'Hero Link List Subtitle!',
      links: CommonComponents\LinkList\LinkList::create(
        links: [
          Atom\Link\Link::create(title: 'Link 1!', url: $url),
          Atom\Link\Link::create(title: 'Link 2!', url: $url),
          Atom\Link\Link::create(title: 'Link 3!', url: $url),
          Atom\Link\Link::create(title: 'Link 4!', url: $url),
          Atom\Link\Link::create(title: 'Link 5!', url: $url),
        ],
        title: Atom\Heading\Heading::create('Popular searches', Atom\Heading\HeadingLevel::Two),
      ),
      searchFormOrActionUrl: CommonComponents\SearchForm\SearchForm::create(actionUrl: 'https://example.com/search'),
    );
  }

  #[Scenario(viewPortWidth: 1000, viewPortHeight: 300)]
  final public static function heroSearchWithContent(): HeroSearch {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $instance = HeroSearch::create(
      title: 'Hero Link List Title!',
      subtitle: 'Hero Link List Subtitle!',
    );
    $instance[] = Atom\Html\Html::create(Markup::create(<<<HTML
      <p>
        <strong>Extra content!</strong>
      </p>
      HTML));
    $instance[] = Atom\Button\Button::create(title: 'Button!', as: Atom\Button\ButtonType::Link);
    return $instance;
  }

}
