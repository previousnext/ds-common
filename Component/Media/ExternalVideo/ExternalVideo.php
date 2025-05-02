<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Media\ExternalVideo;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Utility;

class ExternalVideo implements Component\Media\MediaComponentInterface, Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param positive-int|null $duration
   */
  final private function __construct(
    public readonly string $source,
    public readonly string $title,
    public readonly ?int $duration,
    public Attribute $containerAttributes,
  ) {}

  /**
   * @phpstan-param positive-int|null $duration
   */
  public static function create(
    string $source,
    string $title,
    ?int $duration = NULL,
  ): static {
    return static::factoryCreate(
      source: $source,
      title: $title,
      duration: $duration,
      containerAttributes: new Attribute(),
    );
  }

  public static function createSample(): static {
    return static::create(
      'https://www.youtube.com/watch?v=QrGrOK8oZG8',
      'Too Many Cooks 👨‍🍳',
      671,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('containerAttributes', $this->containerAttributes);
  }

  // @todo fromExternalVideoMedia factory, just like image.
}
