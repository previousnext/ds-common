<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Vo\MenuTree;

use Ramsey\Collection\AbstractCollection;

/**
 * A collection of menu trees.
 *
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree>
 */
final class MenuTrees extends AbstractCollection {

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Vo\\MenuTree\\MenuTree';
  }

}
