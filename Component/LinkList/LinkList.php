<?php

declare(strict_types = 1);

namespace PreviousNext\Ds\Common\Component\LinkList;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Atom\Link\Link>
 */
#[ObjectType\Slots(slots: [
  'items',
  new Slots\Slot('modifier', defaultValue: NULL),
])]
class LinkList extends AbstractCollection {

  use Utility\ObjectTrait;

  private function __construct(
    array $links,
  ) {
    parent::__construct($links);
  }

  public function getType(): string
  {
    return '\\PreviousNext\\Ds\Common\\Atom\\Link\\Link';
  }

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Atom\Link\Link[] $links
   */
  public static function create(
    array $links = [],
  ): static {
    return static::factoryCreate($links);
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('items', $this->map(fn (Atom\Link\Link $link): mixed => $link->renderArray())->toArray())
    ;
  }

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Atom\Link\Link[] $links
   */
  public static function fromLinks(Atom\Link\Links $links): static {
    return new static($links->toArray());
  }

}
