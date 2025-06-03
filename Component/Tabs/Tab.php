<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs;

use PreviousNext\Ds\Common\Vo\Id\Id;

final class Tab {

  private function __construct(
    public readonly Id $id,
    public readonly string $title,
    public readonly string $content,
  ) {
  }

  public static function create(string $title, string $content): static {
    return new static(
      // Create the ID here so we can potentially use it before Tabs::build.
      Id::create(),
      $title,
      $content,
    );
  }

}
