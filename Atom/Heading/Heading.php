<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Heading;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'heading',
  'level',
  'attributes',
])]
#[Scenarios([HeadingScenarios::class])]
class Heading implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<HeadingModifierInterface> $modifiers
   */
  private function __construct(
    public string|Atom\Html\Html $heading,
    public HeadingLevel $level,
    public Attribute $containerAttributes,
    public Modifier\ModifierBag $modifiers,
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
      modifiers: new Modifier\ModifierBag(HeadingModifierInterface::class),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->heading)
      ->set('level', $this->level->element())
      ->set('attributes', $this->containerAttributes);
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->modifiers = clone $this->modifiers;
  }

}
