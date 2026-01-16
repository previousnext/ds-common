<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\UtilityList;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\IdsTools\Scenario\Scenario;

final class UtilityListScenarios {

  /**
   * @phpstan-return \Generator<CommonComponents\UtilityList\UtilityList>
   */
  #[Scenario]
  final public static function standardUtilityList(): \Generator {
    foreach (UtilityListDirection::cases() as $direction) {
      $url = \Mockery::mock(Url::class);
      $url->expects('toString')->andReturn('http://example.com/');
      yield $direction->name => CommonComponents\UtilityList\UtilityList::create($direction);
    }
  }

}
