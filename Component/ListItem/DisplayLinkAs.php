<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\ListItem;

use PreviousNext\Ds\Common\Modifier\Mutex;

#[Mutex]
enum DisplayLinkAs implements ListItemModifierInterface {

  case Inline;
  case Block;

}
