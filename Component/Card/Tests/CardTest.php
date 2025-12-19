<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Component\Card\Card;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;
use PreviousNext\IdsTools\Rendering\ComponentRender;

#[CoversClass(Card::class)]
class CardTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();

    IdsContainer::testContainerForDs('nswds');
  }

  public function testCard(): void {
    // @todo switch to a Card Scenario at CardScenarios in the other branch.
    $card = Card::create(
      image: $image = CommonComponents\Media\Image\Image::createSample(300, 400),
      links: CommonComponents\LinkList\LinkList::create(),
      date: new \DateTimeImmutable('1st January 2001'),
    );

    $image->imageAttributes['test'] = 'image-attr';
    $image->containerAttributes['test'] = 'container-attr';

    $rendered = ComponentRender::renderViaGlobal($card);
    static::assertIsArray($rendered['#image']);
    static::assertEquals(400, $rendered['#image']['#height']);
    // @codingStandardsIgnoreStart
    // static::assertEquals(300, $rendered['#image']['#width']);
    //    static::assertEquals('http://example.com/', $rendered['#link']['#href']);
    //
    //    // Modifiers:
    //    static::assertEquals('text-purple', (string) $rendered['#attributes']->getClass());
    //
    //    // @todo Nsw image container attributes are unused..
    // static::assertEquals('', (string) $rendered['#image']['#attributes']->getClass());
    // static::assertEquals('', (string) $rendered['#image']['#attributes']->getClass());
  }

}
