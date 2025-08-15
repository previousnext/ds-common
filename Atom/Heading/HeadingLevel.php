<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Heading;

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/Heading_Elements
 */
enum HeadingLevel {

  case One;
  case Two;
  case Three;
  case Four;
  case Five;
  case Six;

  public function element(): string {
    return match ($this) {
      static::One => 'h1',
      static::Two => 'h2',
      static::Three => 'h3',
      static::Four => 'h4',
      static::Five => 'h5',
      static::Six => 'h6',
    };
  }

}
