<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Icon;

use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

final class Icon implements CommonObjectInterface {

  use ObjectTrait;

  private function __construct(
    public string $icon,
    public ?string $text,
    public AlignmentType $alignmentType,
    public ?string $modifier,
  ) {
  }

  public static function create(
    string $icon,
    ?string $text = NULL,
    AlignmentType $alignmentType = AlignmentType::Default,
    ?string $modifier = NULL,
  ): static {
    return new static($icon, $text, $alignmentType, $modifier);
  }

}
