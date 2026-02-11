<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\LinkedImage;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom\Link\Link;
use PreviousNext\Ds\Common\Component as CommonComponent;

final class LinkedImageScenarios {

  public static function linkedImage(): LinkedImage {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    return LinkedImage::create(
      CommonComponent\Media\Image\Image::createSample(512, 340),
      Link::create('Linked image text!', $url),
    );
  }

}
