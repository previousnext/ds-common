<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Steps\Step;

use Pinto\Attribute\ObjectType\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;

/**
 * @see \PreviousNext\Ds\Common\Component\Steps\Steps
 */
class Step implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * Constructs a Step.
   *
   * The `enabled` flag is typically controlled by the containing Steps object.
   */
  final private function __construct(
    public Atom\Html\Html $content,
    public bool $isEnabled,
  ) {
  }

  #[Slots(bindPromotedProperties: TRUE)]
  public static function create(
    Atom\Html\Html $content,
  ): static {
    return static::factoryCreate(
      $content,
      FALSE,
    );
  }

}
