<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Vo\MenuTree;

use PreviousNext\Ds\Common\Atom as CommonAtoms;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree>
 */
class MenuTree extends AbstractCollection {

  final private function __construct(
    public CommonAtoms\Link\Link $link,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Vo\\MenuTree\\MenuTree';
  }

  public static function create(
    CommonAtoms\Link\Link $link,
  ): static {
    return new static(
      $link,
    );
  }

  /**
   * Method used by Twig.
   *
   * As in `{% for item in item.items }{%endfor %}`.
   *
   * @phpstan-return static
   */
  public function items(): iterable {
    return $this;
  }

}
