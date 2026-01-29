<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SearchForm;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\Ds\Common\Vo\Id\Id;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'containerAttributes',
  'actionUrl',
  'id',
  'searchFieldName',
])]
#[Scenarios([SearchFormScenarios::class])]
class SearchForm implements CommonObjectInterface {

  use ObjectTrait;

  /**
   * @phpstan-param string $actionUrl
   *   https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#action.
   */
  final private function __construct(
    public readonly Id $id,
    public string $actionUrl,
    public string $searchFieldName,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    string $actionUrl,
    string $searchFieldName = 'q',
  ): static {
    return static::factoryCreate(
      id: Id::create(),
      actionUrl: $actionUrl,
      searchFieldName: $searchFieldName,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('id', (string) $this->id)
      ->set('searchFieldName', $this->searchFieldName)
      ->set('containerAttributes', $this->containerAttributes)
      ->set('actionUrl', $this->actionUrl);
  }

}
