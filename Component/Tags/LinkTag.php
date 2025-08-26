<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tags;

final class LinkTag {

  private function __construct(
    public string $title,
    public string $href,
  ) {
  }

  public static function create(
    string $title,
    string $href,
  ): static {
    return new static(
      title: $title,
      href: $href,
    );
  }

}
