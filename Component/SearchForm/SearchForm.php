<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SearchForm;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Atom\Button\ButtonType;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'containerAttributes',
  'actionUrl',
  'input',
  'button',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([SearchFormScenarios::class])]
class SearchForm implements CommonObjectInterface {

  use ObjectTrait;

  /**
   * @phpstan-param string $actionUrl
   *   https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/form#action.
   */
  final private function __construct(
    private string $actionUrl,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    string $actionUrl,
  ): static {
    return static::factoryCreate(
      $actionUrl,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    $icon = CommonAtoms\Icon\Icon::create('search');
    $icon->attributes['class'][] = 'mx-icon--search';

    return $build
      ->set('input', 'Foo')
      ->set('button', CommonAtoms\Button\Button::create(
        'Search',
        ButtonType::Submit,
        iconOnly: TRUE,
        iconStart: $icon,
      ))
      ->set('containerAttributes', $this->containerAttributes)
      ->set('actionUrl', $this->actionUrl);
  }

}
