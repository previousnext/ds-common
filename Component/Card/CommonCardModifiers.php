<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card;

enum CommonCardModifiers implements CardModifierInterface {

  case Modifier1;
  case Modifier2;

  public function className(): ?string {
    return match ($this) {
      static::Modifier1 => 'text-purple',
      default => NULL
    };
  }

}
