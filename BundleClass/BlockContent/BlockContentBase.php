<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\BlockContent;

use Drupal\block_content\Entity\BlockContent;
use PreviousNext\Ds\Common\BundleClass\Attribute\BundleClassMetadata;

abstract class BlockContentBase extends BlockContent {

  /**
   * {@inheritdoc}
   */
  public static function create(array $values = []) {
    $values['type'] = BundleClassMetadata::reflectOn(static::class);
    return parent::create($values);
  }

}
