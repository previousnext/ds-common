<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare\Tests;

use Drupal\Core\Url;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Component\Card\Card;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;

#[CoversClass(Card::class)]
final class SocialShareTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();

    IdsContainer::testContainerForDs('nswds');
  }

  public function testCount(): void {
    $socialShare = CommonComponents\SocialShare\SocialShare::create();

    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $socialShare->addSocialMedia(DemoSocialMedia::Digg, $url);
    $socialShare->addSocialMedia(DemoSocialMedia::Odeo, $url);

    static::assertCount(2, $socialShare);
  }

}
