<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tags;

final class Tag {

  private function __construct(
    public string $title,
  ) {
  }

  public static function create(string $title): static {
    return new static(
      title: $title,
    );
  }

}
