<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\InPageAlert;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'heading',
  'type',
  'content',
  'link',
])]
#[Scenarios([InPageAlertScenarios::class])]
class InPageAlert implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    protected Atom\Heading\Heading $heading,
    protected Type $type,
    protected Atom\Html\Html $content,
    protected ?Atom\Link\Link $link,
  ) {
  }

  public static function create(
    Atom\Heading\Heading $heading,
    Type $type,
    Atom\Html\Html $content,
    ?Atom\Link\Link $link = NULL,
  ): static {
    return static::factoryCreate(
      $heading,
      $type,
      $content,
      $link,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->heading)
      ->set('type', $this->type->name)
      ->set('content', $this->content)
      ->set('link', $this->link);
  }

}
