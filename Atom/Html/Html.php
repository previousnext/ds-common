<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Html;

use Drupal\Component\Render\MarkupInterface;

/**
 * Rich text.
 */
final class Html {

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
