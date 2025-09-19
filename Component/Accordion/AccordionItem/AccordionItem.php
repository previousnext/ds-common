<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Accordion\AccordionItem;

use Pinto\Attribute\ObjectType\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;

/**
 * @see \PreviousNext\Ds\Common\Component\Accordion\Accordion
 */
class AccordionItem implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    public string $title,
    public Atom\Html\Html $content,
    public bool $open,
    public ?string $id,
  ) {
  }

  #[Slots(bindPromotedProperties: TRUE)]
  public static function create(
    string $title,
    Atom\Html\Html $content,
    ?bool $open = NULL,
    ?string $id = NULL,
  ): static {
    return static::factoryCreate(
      $title,
      $content,
      $open ?? TRUE,
      $id,
    );
  }

}
