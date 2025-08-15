<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\InPageNavigation;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'heading',
  'includeElements',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([InPageNavigationScenarios::class])]
class InPageNavigation implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<InPageNavigationIncludeElementsInterface> $modifiers
   */
  final private function __construct(
    protected Atom\Heading\Heading $heading,
    public Attribute $containerAttributes,
    public Modifier\ModifierBag $modifiers,
  ) {
  }

  public static function create(
    Atom\Heading\Heading $heading,
  ): static {
    return static::factoryCreate(
      $heading,
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(InPageNavigationIncludeElementsInterface::class),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->heading);
  }

}
