<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Media;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility;

#[ObjectType\Slots(slots: [
  // @todo fix up these
  new Slots\Slot('media', fillValueFromThemeObjectClassPropertyWhenEmpty: 'media'),
  new Slots\Slot('caption', fillValueFromThemeObjectClassPropertyWhenEmpty: 'caption'),
  new Slots\Slot('attribution', fillValueFromThemeObjectClassPropertyWhenEmpty: 'attribution'),
  new Slots\Slot('alignment', fillValueFromThemeObjectClassPropertyWhenEmpty: 'alignment'),
  'mediaType',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
class Media implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    public readonly MediaComponentInterface $media,
    public readonly ?string $caption,
    public readonly ?string $attribution,
    public readonly MediaAlignmentType $alignment,
    public Attribute $containerAttributes,
  ) {}

  public static function create(
    MediaComponentInterface $media,
    ?string $caption = NULL,
    ?string $attribution = NULL,
    MediaAlignmentType $alignment = MediaAlignmentType::Default,
  ): static {
    return static::factoryCreate(
      $media,
      $caption,
      $attribution,
      $alignment,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('mediaType', (new \ReflectionClass($this->media))->getShortName());
  }

}
