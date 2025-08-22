<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Section;

final class SectionItem {

  private function __construct(
    public mixed $content,
  ) {
  }

  public static function create(mixed $content): static {
    return new static(
      content: $content,
    );
  }

}
