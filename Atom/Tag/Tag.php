<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Tag;

use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

final class Tag implements CommonObjectInterface {

  use ObjectTrait;

  private function __construct(
    public readonly string $title,
  ) {
  }

  public static function create(string $title): static {
    return new static($title);
  }

}
