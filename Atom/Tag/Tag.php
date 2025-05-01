<?php

declare(strict_types = 1);

namespace PreviousNext\Ds\Common\Atom\Tag;

use PreviousNext\Ds\Common\Component;

final class Tag {

  private function __construct(
    public readonly string $title,
  ) {
  }

  public static function new(string $title): static {
    return new static($title);
  }

}
