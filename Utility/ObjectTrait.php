<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Utility;

use Drupal\Core\Cache;
use Drupal\pinto\Object as PintoObject;
use Pinto\CanonicalProduct\CanonicalFactoryTrait;
use Pinto\Slots;

/**
 * @phpstan-require-implements \PreviousNext\Ds\Common\Utility\CommonObjectInterface
 */
trait ObjectTrait {

  use CanonicalFactoryTrait {
    // Refer to the original method via factoryCreate
    CanonicalFactoryTrait::factoryCreate as protected;
  }
  use PintoObject\DrupalObjectTrait;
  use Cache\RefinableCacheableDependencyTrait;



  final public function __invoke(): array {
    $built = $this->pintoBuild(function (mixed $build): mixed {
      return $this->build($build);
    });

    if (FALSE === \is_array($built)) {
      throw new \LogicException(\sprintf('Expected %s::transform to convert %s to an array.', PintoObject\PintoToDrupalBuilder::class, Slots\Build::class));
    }

    (new Cache\CacheableMetadata())->addCacheableDependency($this)->applyTo($built);

    $this->postModifyRenderArray($built);

    return $built;
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build;
  }

  protected function postModifyRenderArray(array &$built): void {}

}
