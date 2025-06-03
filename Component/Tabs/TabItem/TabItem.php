<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs\TabItem;

use Pinto\Attribute\ObjectType\Slots;
use PreviousNext\Ds\Common\Utility;

/**
 * A TabItem are the tab contents.
 *
 * @see \PreviousNext\Ds\Common\Component\Tabs\Tabs
 */
class TabItem implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    // Title is?
    public string $title,
    public string $content,
    public string $id,
  ) {
  }

  #[Slots(bindPromotedProperties: TRUE)]
  public static function create(
    string $id,
    string $title,
    string $content,
  ): static {
    return static::factoryCreate(
      $title,
      $content,
      $id,
    );
  }

}
