<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tags;

use PreviousNext\Ds\Common\Vo\Id\Id;

final class CheckboxTag {

  private function __construct(
    // Names must not be changed as to match Twig variables.
    public readonly Id $id,
    public string $name,
    public string $value,
    public bool $checked,
    public string $label,
  ) {
  }

  public static function create(
    string $checkboxName,
    string $checkboxValue,
    string $label,
    bool $isChecked = FALSE,
    ?Id $labelId = NULL,
  ): static {
    return new static(
      id: $labelId ?? Id::create(),
      name: $checkboxName,
      value: $checkboxValue,
      checked: $isChecked,
      label: $label,
    );
  }

}
