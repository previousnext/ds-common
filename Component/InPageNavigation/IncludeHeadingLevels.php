<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\InPageNavigation;

enum IncludeHeadingLevels implements InPageNavigationIncludeElementsInterface {

  case H1;
  case H2;
  case H3;
  case H4;
  case H5;
  case H6;

  public function selector(): string {
    return \strtolower($this->name);
  }

}
