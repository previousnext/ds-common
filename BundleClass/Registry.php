<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass;

use PreviousNext\Ds\Common\BundleClass;

final class Registry {

  private static array $classes = [
    BundleClass\BlockContent\Card\CardBundle::class,
    BundleClass\TaxonomyTerm\TermTag::class,
  ];

  /**
   * @phpstan-return iterable<class-string<\Drupal\Core\Entity\EntityInterface>, \PreviousNext\Ds\Common\BundleClass\Attribute\BundleClassMetadata>
   */
  public static function bundleClasses(): iterable {
    foreach (self::$classes as $className) {
      yield $className => Attribute\BundleClassMetadata::reflectOn($className);
    }
  }

}
