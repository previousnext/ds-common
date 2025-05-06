<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Heading;

use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

final class Heading implements CommonObjectInterface {

  use ObjectTrait;

  private function __construct(
    public string $heading,
  ) {
  }

  public static function create(string $heading): static {
    return new static($heading);
  }

}
