<?php

declare(strict_types = 1);

namespace PreviousNext\Ds\Common\Component\Card;

use PreviousNext\Ds\Common\Atom;

interface CardModifierInterface extends \UnitEnum {

  public function className(): ?string;

}
