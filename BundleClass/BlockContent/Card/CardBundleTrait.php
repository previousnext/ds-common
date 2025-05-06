<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\BlockContent\Card;

use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;
use Drupal\link\Plugin\Field\FieldType\LinkItem;
use Drupal\media\MediaInterface;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\BundleClass\BlockContent;

/**
 * @phpstan-require-implements \PreviousNext\Ds\Common\Component\Card\CardDataInterface
 * @phpstan-require-implements \Drupal\Core\Entity\ContentEntityInterface
 */
trait CardBundleTrait {

  final public function getLinks(): Atom\Link\Links {
    $links = new Atom\Link\Links();

    foreach ($this->get(BlockContent\Card\Fields::CardLinks->getMachineName()) as $linkItem) {
      \assert($linkItem instanceof LinkItem);
      $links[] = Atom\Link\Link::create(
        $linkItem->getTitle(),
        $linkItem->getUrl(),
      );
    }

    return $links;
  }

  final public function setLinks(): static {
    // @todo implement
    return $this;
  }

  final public function getCardImage(): ?MediaInterface {
    return $this->get(BlockContent\Card\Fields::CardImage->getMachineName())->entity ?? NULL;
  }

  final public function setCardImage(MediaInterface $image): static {
    return $this->set(BlockContent\Card\Fields::CardImage->getMachineName(), $image);
  }

  final public function getCardDate(): ?\DateTimeImmutable {
    /** @var \Drupal\Core\Datetime\DrupalDateTime|NULL $date */
    $date = $this->get(BlockContent\Card\Fields::CardDate->getMachineName())->date ?? NULL;
    return $date !== NULL ? \DateTimeImmutable::createFromMutable($date->getPhpDateTime()) : NULL;
  }

  final public function setCardDate(\DateTimeInterface $date): static {
    return $this->set(
      BlockContent\Card\Fields::CardDate->getMachineName(),
      $date
        ->setTimezone(new \DateTimeZone(DateTimeItemInterface::STORAGE_TIMEZONE))
        ->format(DateTimeItemInterface::DATETIME_STORAGE_FORMAT),
    );
  }

}
