<?php

declare(strict_types=1);


namespace PreviousNext\Ds\Common\BundleClass\ExpectedFields;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;

final class EntityReferenceResolver {

  /**
   * @phpstan-param array<class-string<\Drupal\Core\Entity\EntityInterface>> $targetBundleClasses
   * @phpstan-return array<class-string<\Drupal\Core\Entity\EntityInterface>, array{string, string}>
   */
  public static function resolve(array $targetBundleClasses): \Generator {
    $allBundleInfo = static::bundleInfo()->getAllBundleInfo();

    foreach ($allBundleInfo as $entityTypeId => $bundles) {
      foreach ($bundles as $bundle => $bundleInfo) {
        $bundleClass = $bundleInfo['class'] ?? NULL;
        if ($bundleClass === NULL) {
          continue;
        }

        $rClass = new \ReflectionClass($bundleClass);
        foreach ($targetBundleClasses as $targetBundleClass) {
          if ($rClass->implementsInterface($targetBundleClass)) {
            yield $bundleClass => ['entityTypeId' => $entityTypeId, 'bundle' => $bundle];
          }
        }
      }
    }
  }

  private static function bundleInfo(): EntityTypeBundleInfoInterface {
    return \Drupal::service(EntityTypeBundleInfoInterface::class);
  }

}


  //repos/common-lib/BundleClass/TaxonomyTerm/TermTagInterface.php
