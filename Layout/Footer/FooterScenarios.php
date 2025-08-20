<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Footer;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTree;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTrees;
use PreviousNext\Ds\Mixtape\Atom\Icon\Icons;
use PreviousNext\Ds\Mixtape\Atom\Icon\IconSize;
use PreviousNext\Ds\Mixtape\Layout\Footer\FooterBackground;
use PreviousNext\IdsTools\Scenario\Scenario;

final class FooterScenarios {

  /**
   * @phpstan-return \Generator<\PreviousNext\Ds\Common\Layout\Footer\Footer>
   */
  #[Scenario(viewPortHeight: 600, viewPortWidth: 1200)]
  final public static function standard(): \Generator {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    // Level 1:
    $menu = new MenuTrees();
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('News', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('About us', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Contact', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Resources', $url));

    $links = new CommonAtoms\Link\Links();
    $links[] = CommonAtoms\Link\Link::create('Terms & Conditions', $url);
    $links[] = CommonAtoms\Link\Link::create('Accessibility', $url);

    $instance = Footer::create(
      logos: CommonAtoms\LinkedImage\LinkedImage::create(
        CommonComponents\Media\Image\Image::createSample(120, 49),
        CommonAtoms\Link\Link::create('LinkedImageText!', $url),
      ),
      description: 'We acknowledge the traditional owners and custodians of country throughout Australia and acknowledges their continuing connection to land, waters and community. We pay our respects to the people, the cultures and the elders past, present and emerging.',
      copyright: '© 2025 Company Name',
      menu: $menu,
      links: $links,
    );

    if ($instance instanceof \PreviousNext\Ds\Mixtape\Layout\Footer\Footer) {
      foreach (FooterBackground::cases() as $background) {
        $i = clone $instance;
        $i->modifiers[] = $background;
        yield \sprintf('standard-bg-%s', $background->background()) => $i;
      }

      return;
    }

    yield $instance;
  }

  #[Scenario(viewPortHeight: 600, viewPortWidth: 1200)]
  final public static function withAcknowledgment(): Footer {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    // Level 1:
    $menu = new MenuTrees();
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('News', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('About us', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Contact', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Resources', $url));

    $links = new CommonAtoms\Link\Links();
    $links[] = CommonAtoms\Link\Link::create('Terms & Conditions', $url);
    $links[] = CommonAtoms\Link\Link::create('Accessibility', $url);

    $instance = Footer::create(
      logos: CommonAtoms\LinkedImage\LinkedImage::create(
        CommonComponents\Media\Image\Image::createSample(120, 49),
        CommonAtoms\Link\Link::create('LinkedImageText!', $url),
      ),
      description: 'We acknowledge the traditional owners and custodians of country throughout Australia and acknowledges their continuing connection to land, waters and community. We pay our respects to the people, the cultures and the elders past, present and emerging.',
      copyright: '© 2025 Company Name',
      menu: $menu,
      links: $links,
    );

    return $instance;
  }

  #[Scenario(viewPortHeight: 600, viewPortWidth: 1200)]
  final public static function noMenu(): Footer {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $links = new CommonAtoms\Link\Links();
    $links[] = CommonAtoms\Link\Link::create('Terms & Conditions', $url);
    $links[] = CommonAtoms\Link\Link::create('Accessibility', $url);

    $instance = Footer::create(
      logos: CommonAtoms\LinkedImage\LinkedImage::create(
        CommonComponents\Media\Image\Image::createSample(120, 49),
        CommonAtoms\Link\Link::create('LinkedImageText!', $url),
      ),
      copyright: '© 2025 Company Name',
      links: $links,
    );

    return $instance;
  }

  #[Scenario(viewPortHeight: 600, viewPortWidth: 1200)]
  final public static function everything(): Footer {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    // Level 1:
    $menu = new MenuTrees();
    $menu[] = $treeA = MenuTree::create(CommonAtoms\Link\Link::create('News', $url));
    $menu[] = $treeB = MenuTree::create(CommonAtoms\Link\Link::create('About us', $url));
    $menu[] = $treeC = MenuTree::create(CommonAtoms\Link\Link::create('Contact', $url));

    // Level 2:
    $treeA[] = MenuTree::create(CommonAtoms\Link\Link::create('Events', $url));
    $treeA[] = MenuTree::create(CommonAtoms\Link\Link::create('Media Releases', $url));
    $treeB[] = MenuTree::create(CommonAtoms\Link\Link::create('Resources', $url));
    $treeB[] = MenuTree::create(CommonAtoms\Link\Link::create('Who we are', $url));
    $treeB[] = MenuTree::create(CommonAtoms\Link\Link::create('Join Us', $url));
    $treeC[] = MenuTree::create(CommonAtoms\Link\Link::create('Form', $url));
    $treeC[] = MenuTree::create(CommonAtoms\Link\Link::create('Careers', $url));

    $links = new CommonAtoms\Link\Links();
    $links[] = CommonAtoms\Link\Link::create('Terms & Conditions', $url);
    $links[] = CommonAtoms\Link\Link::create('Accessibility', $url);

    $socialLinks = CommonComponents\SocialLinks\SocialLinks::create('Social media links');
    $instance = Footer::create(
      logos: CommonAtoms\LinkedImage\LinkedImage::create(
        CommonComponents\Media\Image\Image::createSample(120, 49),
        CommonAtoms\Link\Link::create('LinkedImageText!', $url),
      ),
      copyright: '© 2025 Company Name',
      menu: $menu,
      socialLinks: $socialLinks,
      links: $links,
    );

    $fbIcon = CommonAtoms\Icon\Icon::create();
    if ($instance instanceof \PreviousNext\Ds\Mixtape\Layout\Footer\Footer) {
      $fbIcon->modifiers[] = Icons::Facebook;
      $fbIcon->modifiers[] = IconSize::Medium;
    }
    $igIcon = CommonAtoms\Icon\Icon::create();
    if ($instance instanceof \PreviousNext\Ds\Mixtape\Layout\Footer\Footer) {
      $igIcon->modifiers[] = Icons::Instagram;
      $igIcon->modifiers[] = IconSize::Medium;
    }
    $liIcon = CommonAtoms\Icon\Icon::create();
    if ($instance instanceof \PreviousNext\Ds\Mixtape\Layout\Footer\Footer) {
      $liIcon->modifiers[] = Icons::Linkedin;
      $liIcon->modifiers[] = IconSize::Medium;
    }

    $socialLinks[] = CommonAtoms\Link\Link::create('Facebook', $url, iconStart: $fbIcon);
    $socialLinks[] = CommonAtoms\Link\Link::create('Instagram', $url, iconStart: $igIcon);
    $socialLinks[] = CommonAtoms\Link\Link::create('LinkedIn', $url, iconStart: $liIcon);
    $socialLinks[] = CommonAtoms\LinkedImage\LinkedImage::create(
      CommonComponents\Media\Image\Image::createSample(24, 24),
      CommonAtoms\Link\Link::create('LinkedImageText!', $url),
    );

    return $instance;
  }

}
