<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier;

/**
 * Represents an object/enum/etc that equates to a single class.
 */
interface ModifierClassInterface {

  public function className(): string;

}
