<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\ListItem;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\IdsTools\Scenario\Scenario;

final class ListItemScenarios {

  final public static function basic(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        MARKUP,
      )),
    );
    return $instance;
  }

  final public static function blockLink(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        MARKUP,
      )),
    );
    $instance->modifiers[] = DisplayLinkAs::Block;

    return $instance;
  }

  final public static function withInfo(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        MARKUP,
      )),
      label: <<<MARKUP
        Publication
        MARKUP,
      info: <<<MARKUP
        25 May 2025
        MARKUP,
      infoPosition: InfoPosition::Before,
    );
    return $instance;
  }

  final public static function withUrl(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        MARKUP,
      )),
      info: <<<MARKUP
        https://example.com/some-thing
        MARKUP,
      infoPosition: InfoPosition::After,
    );
    return $instance;
  }

  final public static function withTags(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        MARKUP,
      )),
      label: <<<MARKUP
        Resource
        MARKUP,
      tags: CommonComponents\Tags\Tags::create([
        CommonComponents\Tags\Tag::create('Tag 1'),
        CommonComponents\Tags\Tag::create('Tag 2'),
        CommonComponents\Tags\Tag::create('Tag 3'),
      ]),
    );
    return $instance;
  }

  /**
   * @phpstan-return \Generator<ListItem>
   */
  #[Scenario(viewPortWidth: 1000)]
  final public static function withImage(): \Generator {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    foreach (ImagePosition::cases() as $imagePosition) {
      /** @var ListItem $instance */
      $instance = ListItem::create(
        link: Atom\Link\Link::create('Link 1', $url),
        content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        MARKUP,
        )),
        label: <<<MARKUP
        Publication
        MARKUP,
        image: CommonComponents\Media\Image\Image::createSample(120, 49),
        info: <<<MARKUP
        25 May 2025
        MARKUP,
        infoPosition: InfoPosition::Before,
      );
      $instance->modifiers[] = $imagePosition;

      yield \sprintf('position-%s', $imagePosition->name) => $instance;
    }
  }

  final public static function everything(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      image: CommonComponents\Media\Image\Image::createSample(120, 49),
      tags: CommonComponents\Tags\Tags::create([
        CommonComponents\Tags\Tag::create('Tag 1'),
        CommonComponents\Tags\Tag::create('Tag 2'),
        CommonComponents\Tags\Tag::create('Tag 3'),
      ]),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        Welcome to the <strong>Jungle</strong> 🎸
        MARKUP)),
      info: <<<MARKUP
        Welcome to the Jungle 🎸
        MARKUP,
      label: <<<MARKUP
        A label 🦊
        MARKUP,
      infoPosition: InfoPosition::After,
    );
    $instance->containerAttributes['foo'] = 'bar';
    $instance->containerAttributes['class'][] = 'hello';
    return $instance;
  }

  final public static function contentCollection(): ListItem {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var ListItem $instance */
    $instance = ListItem::create(
      link: Atom\Link\Link::create('Link 1', $url),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 0.</p>
        MARKUP)),
    );
    $instance[] = Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 1.</p>
        MARKUP));
    $instance[] = Atom\Button\Button::create(title: 'Item 2', as: Atom\Button\ButtonType::Link);
    return $instance;
  }

}
