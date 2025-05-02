<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Media\Image;

use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Template\Attribute;
use Drupal\media\MediaInterface;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Utility;

#[ObjectType\Slots(slots: [
  'source',
  'altText',
  'width',
  'height',
  'loadingType',
  'sources',
  'imageAttributes',
  'containerAttributes',
])]
class Image implements Component\Media\MediaComponentInterface, Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    // @todo work out optional args...
    protected string $source,
    protected string $altText,
    protected int $width,
    protected int $height,
    protected LoadingType $loadingType,
    // @todo sources: as collection
    protected array $sources,
    public Attribute $imageAttributes,
    public Attribute $containerAttributes,
  ) {}

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Component\Media\Image\ImageSource[] $sources
   */
  public static function create(
    string $source,
    string $altText,
    int $width,
    int $height,
    LoadingType $loadingType = LoadingType::Eager,
    array $sources = [],
  ): static {
    return static::factoryCreate(
      $source,
      $altText,
      $width,
      $height,
      $loadingType,
      $sources,
      containerAttributes: new Attribute(),
      imageAttributes: new Attribute(),
    );
  }

  public static function createSample(int $width, int $height): static {
    return static::create(
      \sprintf('https://picsum.photos/%d/%d', $width, $height),
      'Picsum Sample',
      $width,
      $height,
    );
  }

  public static function fromImageMedia(MediaInterface $image): ?static {
    // @todo fix hard coded values,
    // @todo common image media entity interface
    /** @var \Drupal\file\FileInterface $file */
    $file = $image->field_media_image->entity ?? NULL;
    if ($file === NULL) {
      return NULL;
    }

    $uri = $file->getFileUri();
    if ($uri === NULL) {
      return NULL;
    }

    return static::create(
      static::fileUrlGenerator()->generateAbsoluteString($uri),
      // @todo fix...
      'Alt',
      400,
      300,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('containerAttributes', $this->containerAttributes)
      ->set('imageAttributes', $this->imageAttributes);
  }

  protected static function fileUrlGenerator(): FileUrlGeneratorInterface {
    return \Drupal::service(FileUrlGeneratorInterface::class);
  }

}
