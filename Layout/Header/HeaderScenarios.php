<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Header;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTree;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTrees;
use PreviousNext\Ds\Mixtape\Component\Navigation\NavigationType;
use PreviousNext\IdsTools\Scenario\Scenario;

final class HeaderScenarios {

  #[Scenario(viewPortHeight: 600, viewPortWidth: 1200)]
  final public static function search(): Header {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $menu = new MenuTrees();
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Link A', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Link B', $url));
    $menu[] = MenuTree::create(CommonAtoms\Link\Link::create('Link C', $url));

    $instance = Header::create(
      logo: CommonAtoms\LinkedImage\LinkedImage::create(
        CommonComponents\Media\Image\Image::createSample(120, 49),
        CommonAtoms\Link\Link::create('LinkedImageText!', $url),
      ),
      title: 'Site name!',
      description: 'Site slogan!',
      hasSearch: TRUE,
      menu: $menu,
    );

    if ($instance instanceof \PreviousNext\Ds\Mixtape\Layout\Header\Header) {
      $instance->navigationType = NavigationType::Dropdown;
    }

    return $instance;
  }

}
