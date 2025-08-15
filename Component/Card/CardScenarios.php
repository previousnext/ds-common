<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Component as CommonComponents;

final class CardScenarios {

  final public static function card(): Card {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Card $instance */
    $instance = Card::create(
      image: CommonComponents\Media\Image\Image::createSample(300, 400),
      links: CommonComponents\LinkList\LinkList::create([
        CommonAtoms\Link\Link::create(title: '', url: $url),
      ]),
      date: new \DateTimeImmutable('1 October 2020'),
      heading: Atom\Heading\Heading::create('Example!', \PreviousNext\Ds\Common\Atom\Heading\HeadingLevel::Two),
    );
    return $instance;
  }

}
