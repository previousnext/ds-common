<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Media;

use PreviousNext\Ds\Common\Component;

final class MediaScenarios {

  final public static function externalVideo(): Media {
    /** @var Media $instance */
    $instance = Component\Media\Media::create(
      media: Component\Media\ExternalVideo\ExternalVideo::createSample(),
      caption: 'A video.',
      alignment: Component\Media\MediaAlignmentType::Center,
    );
    return $instance;
  }

  final public static function image(): Media {
    /** @var Media $instance */
    $instance = Component\Media\Media::create(
      media: Component\Media\Image\Image::createSample(256, 256),
      caption: 'An image.',
      alignment: Component\Media\MediaAlignmentType::Center,
    );
    return $instance;
  }

}
