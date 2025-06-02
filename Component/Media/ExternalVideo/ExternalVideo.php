<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Media\ExternalVideo;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([ExternalVideoScenarios::class])]
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
    // We keep this abstraction so we can change scenarios at any time,
    // including downstream.
    return ExternalVideoScenarios::externalVideo();
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('containerAttributes', $this->containerAttributes);
  }

  // @todo fromExternalVideoMedia factory, just like image.
}
