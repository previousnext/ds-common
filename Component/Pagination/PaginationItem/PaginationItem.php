<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Pagination\PaginationItem;

use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;

class PaginationItem implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * Constructs a Page for a Pagination component.
   *
   * The `enabled` flag is typically controlled by the containing Pagination object.
   */
  private function __construct(
    public ?Atom\Link\Link $link,
    public bool $ellipsis,
    /**
     * @internal
     */
    public bool $isEnabled,
  ) {
  }

  public static function create(
    ?Atom\Link\Link $link = NULL,
    bool $ellipsis = FALSE,
  ): static {
    return static::factoryCreate(
      link: $link,
      ellipsis: $ellipsis,
      isEnabled: FALSE,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    if ($this->isEnabled && ($this->link === NULL || $this->ellipsis !== FALSE)) {
      throw new \LogicException('An active pagination item must have a link and no ellipsis.');
    }

    return $build;
  }

}
