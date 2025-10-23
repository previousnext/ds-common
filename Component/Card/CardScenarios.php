<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;

final class CardScenarios {

  final public static function card(): Card {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Card $instance */
    $instance = Card::create(
      image: CommonComponents\Media\Image\Image::createSample(300, 400),
      links: CommonComponents\LinkList\LinkList::create([
        Atom\Link\Link::create(title: '', url: $url),
      ]),
      date: new \DateTimeImmutable('1 October 2020'),
      heading: Atom\Heading\Heading::create('Example!', \PreviousNext\Ds\Common\Atom\Heading\HeadingLevel::Two),
    );
    return $instance;
  }

  final public static function contentCollection(): Card {
    $instance = Card::create(
      image: NULL,
      links: NULL,
      heading: Atom\Heading\Heading::create('Example!', Atom\Heading\HeadingLevel::Two),
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

  final public static function withTags(): Card {
    $tags = CommonComponents\Tags\Tags::create();
    $tags[] = CommonComponents\Tags\Tag::create('Tag 1');
    $tags[] = CommonComponents\Tags\Tag::create('Tag 2');
    $tags[] = CommonComponents\Tags\Tag::create('Tag 3');
    return Card::create(
      image: NULL,
      links: NULL,
      heading: Atom\Heading\Heading::create('Example!', Atom\Heading\HeadingLevel::Two),
      content: Atom\Html\Html::create(Markup::create(<<<MARKUP
          <p>Lorem ipsum.</p>
          MARKUP)),
      tags: $tags,
    );
  }

}
