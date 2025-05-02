<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\BlockContent\Card;

use Drupal\block_content\Entity\BlockContentType;
use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\pinto_block\Attribute\PintoBlock;
use PreviousNext\Ds\Common\BundleClass;
use PreviousNext\Ds\Common\Component\Card;

#[BundleClass\Attribute\BundleClassMetadata('block_content', 'card', ifNotMeThenA: [Card\CardDataInterface::class])]
#[BundleClass\ExpectedFields\ExpectedFields(fields: [
  Fields::CardDate,
  Fields::CardIcon,
  Fields::CardImage,
  Fields::CardLinks,
  Fields::CardTags,
])]
#[PintoBlock(objectClassName: Card\Card::class)]
class CardBundle extends BundleClass\BlockContent\BlockContentBase implements Card\CardDataInterface {

  use CardBundleTrait;

  final public static function createDefaultBundle(): ConfigEntityInterface {
    return BlockContentType::create([
      'label' => 'Card',
      'description' => 'Created by PNX Common.',
      'id' => 'card',
    ]);
  }

}
