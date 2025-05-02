<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid;

use PreviousNext\Ds\Common\Modifier;

/**
 * @todo remove
 * this is for demo purposes to show modifier system can take enums AND OBJECTS.
 */
final class GridClass implements GridModifierInterface, Modifier\ModifierClassInterface {

  public function __construct(
    private string $className,
  ) {
  }

  public function className(): string {
    return $this->className;
  }

}
