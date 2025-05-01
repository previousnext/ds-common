<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\BlockContent\Card;

use Drupal\Core\Field\Plugin\Field\FieldType\EntityReferenceItem;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItem;
use Drupal\link\Plugin\Field\FieldType\LinkItem;
use PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFieldInterface;
use PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFieldTrait;
use PreviousNext\Ds\Common\BundleClass\ExpectedFields\UnlimitedCardinality;
use PreviousNext\Ds\Common\BundleClass\TaxonomyTerm\TermTagInterface;

enum Fields: string implements ExpectedFieldInterface {

  case CardDate = 'card_date';
  case CardIcon = 'card_icon';
  case CardImage = 'card_image';
  case CardLinks = 'card_links';
  case CardTags = 'card_tags';

  use ExpectedFieldTrait;

  public function getMachineName(): string {
    return $this->value;
  }

  public function fieldInterface(): string {
    return match ($this) {
      static::CardDate => DateTimeItem::class,
      static::CardIcon => EntityReferenceItem::class,
      static::CardImage => EntityReferenceItem::class,
      static::CardLinks => LinkItem::class,
      static::CardTags => EntityReferenceItem::class,
    };
  }

  public function isRequired(): bool {
    return match ($this) {
      static::CardDate => FALSE,
      static::CardIcon => FALSE,
      static::CardImage => FALSE,
      static::CardLinks => FALSE,
      static::CardTags => FALSE,
    };
  }

  public function cardinality(): int|UnlimitedCardinality {
    return match ($this) {
      static::CardDate => 1,
      static::CardIcon => 1,
      static::CardImage => 1,
      static::CardLinks => new UnlimitedCardinality(),
      static::CardTags => new UnlimitedCardinality(),
    };
  }

  public function storageSettings(): array {
    return match ($this) {
      static::CardIcon, static::CardImage => [
        'target_type' => 'media',
      ],
      static::CardTags => [
        'target_type' => 'taxonomy_term',
      ],
      default => [],
    };
  }

  public function instanceSettings(): array {
    return static::entityReferenceInstanceSettings() + match ($this) {
      default => [],
    };
  }

  public function entityReferenceTargets(): array {
    return match ($this) {
      static::CardTags => [TermTagInterface::class],
      // Not an ER field:
      default => [],
    };
  }

}
