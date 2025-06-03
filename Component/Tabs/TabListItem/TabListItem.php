<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs\TabListItem;

use Pinto\Attribute\ObjectType\Slots;
use PreviousNext\Ds\Common\Utility;

/**
 * A TabListItem are the tab buttons.
 *
 * @see \PreviousNext\Ds\Common\Component\Tabs\Tabs
 */
class TabListItem implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    public string $id,
    public string $title,
    public bool $active,
  ) {
  }

  #[Slots(bindPromotedProperties: TRUE)]
  public static function create(
    string $id,
    string $title,
    bool $active = FALSE,
  ): static {
    return static::factoryCreate(
      $id,
      $title,
      $active,
    );
  }

}
