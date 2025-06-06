<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card;

use Drupal\media\MediaInterface;
use PreviousNext\Ds\Common\Atom;

/**
 * @todo heading, content, link, modifier
 */
interface CardDataInterface {

  public function getLinks(): Atom\Link\Links;

  /**
   * @phpstan-return $this
   */
  public function setLinks(): static;

  public function getCardImage(): ?MediaInterface;

  /**
   * @phpstan-return $this
   */
  public function setCardImage(MediaInterface $image): static;

  public function getCardDate(): ?\DateTimeImmutable;

  /**
   * @phpstan-return $this
   */
  public function setCardDate(\DateTimeInterface $date): static;

}
