<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid;

enum GridType {

  case Div;
  case Section;
  case Header;
  case Footer;
  case Aside;
  case List;

  public function element(): string {
    return match ($this) {
      self::Div => 'div',
      self::Section => 'section',
      self::Header => 'header',
      self::Footer => 'footer',
      self::Aside => 'aside',
      self::List => 'ul',
    };
  }

}
