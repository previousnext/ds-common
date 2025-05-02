<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Tag;

use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Atom\Tag\Tag>
 */
final class Tags extends AbstractCollection {

  public function getType(): string {
    return '\PreviousNext\\Ds\Common\\Atom\\Tag\\Tag';
  }

}
