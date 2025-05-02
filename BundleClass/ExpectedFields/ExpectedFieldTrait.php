<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\ExpectedFields;

use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldConfigInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\field\FieldStorageConfigInterface;
use PreviousNext\Ds\Common\BundleClass\Attribute\BundleClassMetadata;
use function Symfony\Component\String\u;

/**
 * @phpstan-require-implements \PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFieldInterface
 */
trait ExpectedFieldTrait {

  public function fieldStorage(BundleClassMetadata $metadata): FieldStorageConfigInterface {
    $rFieldType = new \ReflectionClass($this->fieldInterface());
    $fieldType = ($rFieldType->getAttributes(FieldType::class)[0] ?? throw new \LogicException('Missing ' . FieldType::class . ' attribute on ' . $this->fieldInterface()))->newInstance();

    return FieldStorageConfig::create([
      'type' => $fieldType->id,
      'field_name' => $this->value,
      'entity_type' => $metadata->entityTypeId,
      'bundle' => $metadata->bundle,
      'cardinality' => $this->cardinality() instanceof UnlimitedCardinality ? FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED : $this->cardinality(),
    ]);
  }

  public function fieldInstance(BundleClassMetadata $metadata): FieldConfigInterface {
    return FieldConfig::create([
      'label' => (string) u($this->value)->snake()->replace('_', ' ')->title(allWords: TRUE),
      'field_name' => $this->value,
      'entity_type' => $metadata->entityTypeId,
      'bundle' => $metadata->bundle,
      'required' => $this->isRequired(),
    ]);
  }

  public function entityReferenceTargets(): array {
    return match ($this) {
      default => throw new \LogicException('Not an ER field'),
    };
  }

  public function entityReferenceInstanceSettings(): array {
    $erTargets = \iterator_to_array(EntityReferenceResolver::resolve($this->entityReferenceTargets()));

    $bundles = \array_column($erTargets, 'bundle');

    if ([] === $bundles) {
      return [];
    }

    return [
      'handler_settings' => [
        'target_bundles' => \array_combine($bundles, $bundles),
      ],
    ];
  }

}
