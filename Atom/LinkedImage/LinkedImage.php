<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\LinkedImage;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

class LinkedImage implements CommonObjectInterface {

  use ObjectTrait;

  final private function __construct(
    protected CommonComponents\Media\Image\Image $image,
    protected CommonAtoms\Link\Link $link,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    CommonComponents\Media\Image\Image $image,
    CommonAtoms\Link\Link $link,
  ): static {
    return static::factoryCreate(
      $image,
      $link,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build;
  }

}
