<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialLinks;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\IdsTools\Scenario\Scenario;

final class SocialLinksScenarios {

  #[Scenario(viewPortHeight: 600, viewPortWidth: 1200)]
  final public static function standard(): CommonComponents\SocialLinks\SocialLinks {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    $instance = CommonComponents\SocialLinks\SocialLinks::create('Title!');
    $instance[] = CommonAtoms\Link\Link::create('Text Link', $url);
    $instance[] = CommonAtoms\LinkedImage\LinkedImage::create(
      CommonComponents\Media\Image\Image::createSample(24, 24),
      CommonAtoms\Link\Link::create('LinkedImageText!', $url),
    );
    return $instance;
  }

}
