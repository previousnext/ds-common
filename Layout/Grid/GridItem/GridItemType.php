<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid\GridItem;

enum GridItemType {

  case Div;
  case ListItem;
  case Article;
  case Aside;
  case Section;

  public function element(): string {
    return match ($this) {
      self::Div => 'div',
      self::ListItem => 'li',
      self::Article => 'article',
      self::Aside => 'aside',
      self::Section => 'section',
    };
  }

}
