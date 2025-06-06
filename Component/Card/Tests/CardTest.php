<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card\Tests;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use PHPUnit\Framework\TestCase;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\List\CommonLists;
use PreviousNext\Ds\Nsw\Lists\NswLists;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;

class CardTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();
    $container = new ContainerBuilder();
    $container->setParameter('ids.design_system', 'nsw');
    $container->setParameter('ids.design_system.additional', ['common']);
    $container->setParameter('ids.design_systems', [
      'nsw' => NswLists::Lists,
      'common' => CommonLists::Lists,
    ]);
    IdsContainer::setupContainer($container);
    $container->compile();
  }

  /**
   * @covers \PreviousNext\Ds\Common\Component\Card\Card
   */
  public function testCard(): void {
    // @todo switch to a Card Scenario at CardScenarios in the other branch.
    $card = CommonComponents\Card\Card::create(
      image: $image = CommonComponents\Media\Image\Image::createSample(300, 400),
      links: CommonComponents\LinkList\LinkList::create(),
      date: new \DateTimeImmutable('1st January 2001'),
      // @todo replace with real modifiers
      modifiers: [CommonComponents\Card\CommonCardModifiers::Modifier1],
    );

    $image->imageAttributes['test'] = 'image-attr';
    $image->containerAttributes['test'] = 'container-attr';

    $rendered = $card();
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
