<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare\Tests;

use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\Core\Url;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Component\Card\Card;
use PreviousNext\IdsTools\DependencyInjection\IdsContainer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(Card::class)]
final class SocialShareTest extends TestCase {

  protected function setUp(): void {
    parent::setUp();

    IdsContainer::testContainerForDs('nswds', beforeCompile: static function (ContainerBuilder $containerBuilder): void {
      $containerBuilder->set('url_generator', $urlGenerator = \Mockery::mock(UrlGeneratorInterface::class));

      $urlGenerator->shouldReceive('generateFromRoute')
        ->with('<current>', [], [], FALSE)
        ->andReturn('http://example.com/foo-bar');
    });
  }

  public function testCount(): void {
    $socialShare = CommonComponents\SocialShare\SocialShare::create();

    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $socialShare->addSocialMedia(DemoSocialMedia::Digg, $url);
    $socialShare->addSocialMedia(DemoSocialMedia::Odeo, $url);

    static::assertCount(2, $socialShare);
  }

  public function testDefaultUrl(): void {
    $socialShare = CommonComponents\SocialShare\SocialShare::create();

    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $socialShare->addSocialMedia(DemoSocialMedia::Digg);

    static::assertEquals(
      new CommonComponents\SocialShare\SocialMediaUrl(DemoSocialMedia::Digg, Url::fromUri('https://digg.com/submit?url=http://example.com/foo-bar')),
      \iterator_to_array($socialShare->modifiers)[0],
    );
  }

}
