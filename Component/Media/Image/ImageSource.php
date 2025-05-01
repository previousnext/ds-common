<?php

declare(strict_types = 1);

namespace PreviousNext\Ds\Common\Component\Media\Image;

final class ImageSource {

  private function __construct(
    public string $srcset,
    public string $media,
    public string $type,
  ) {
  }

  public static function create(
    string $srcset,
    string $media,
    string $type,
  ) {
    return new static($srcset, $media, $type);
  }

}
