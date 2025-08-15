<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Heading;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([HeadingScenarios::class])]
#[ObjectType\Slots(slots: [
  'heading',
  'level',
  'attributes',
])]
final class Heading implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private function __construct(
    public string|Atom\Html\Html $heading,
    public HeadingLevel $level,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    string|Atom\Html\Html $heading,
    HeadingLevel $level,
  ): static {
    return static::factoryCreate(
      heading: $heading,
      level: $level,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->heading)
      ->set('level', $this->level->element())
      ->set('attributes', $this->containerAttributes);
  }

}
