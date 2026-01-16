<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\UtilityList;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'direction',
  'hasCopy',
  'hasPrint',
  'hasPdf',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([UtilityListScenarios::class])]
class UtilityList implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    protected UtilityListDirection $direction,
    protected bool $hasCopy,
    protected bool $hasPrint,
    protected bool $hasPdf,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    UtilityListDirection $direction,
    bool $hasCopy = TRUE,
    bool $hasPrint = TRUE,
    bool $hasPdf = TRUE,
  ): static {
    return static::factoryCreate(
      direction: $direction,
      hasCopy: $hasCopy,
      hasPrint: $hasPrint,
      hasPdf: $hasPdf,
      containerAttributes: new Attribute(),
    );
  }

}
