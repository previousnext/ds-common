<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\ExpectedFields;

use Drupal\Core\Field\FieldConfigInterface;
use Drupal\field\FieldStorageConfigInterface;
use PreviousNext\Ds\Common\BundleClass\Attribute\BundleClassMetadata;

interface ExpectedFieldInterface extends \BackedEnum {

  public function getMachineName(): string;

  /**
   * @return class-string<\Drupal\Core\Field\FieldItemInterface>
   */
  public function fieldInterface(): string;

  /**
   * @phpstan-return positive-int|UnlimitedCardinality
   */
  public function cardinality(): int|UnlimitedCardinality;

  public function isRequired(): bool;

  /**
   * Create an unsaved config.
   */
  public function fieldStorage(BundleClassMetadata $metadata): FieldStorageConfigInterface;

  /**
   * Create an unsaved config.
   */
  public function fieldInstance(BundleClassMetadata $metadata): FieldConfigInterface;

  /**
   * @return array<string, mixed>
   */
  public function storageSettings(): array;

  /**
   * @return array<string, mixed>
   */
  public function instanceSettings(): array;

  public function entityReferenceTargets(): array;

  public function entityReferenceInstanceSettings(): array;

}
