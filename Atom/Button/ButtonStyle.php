<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Button;

use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Modifier\Mutex;

#[Mutex]
enum ButtonStyle implements CommonAtoms\Button\ButtonModifierInterface {

  case Dark;
  case Destructive;
  case Light;
  case Outline;
  case White;


}
