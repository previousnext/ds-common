<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Html;

use Drupal\Component\Render\MarkupInterface;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

/**
 * Rich text.
 */
final class Html implements CommonObjectInterface {

  use ObjectTrait;

  private function __construct(
    public MarkupInterface $markup,
  ) {
  }

  public static function create(
    MarkupInterface $markup,
  ): static {
    return new static($markup);
  }

}
