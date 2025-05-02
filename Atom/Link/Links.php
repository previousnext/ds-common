<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Atom\Link\Link>
 */
final class Links extends AbstractCollection {

  public function getType(): string {
    return '\PreviousNext\\Ds\Common\\Atom\\Link\\Link';
  }

}
