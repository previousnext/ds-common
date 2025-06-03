<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Header;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Atom\LinkedImage\LinkedImage;
use PreviousNext\Ds\Common\Component\SearchForm\SearchForm;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\Collection;
use Ramsey\Collection\CollectionInterface;

#[
  ObjectType\Slots(slots: [HeaderSlots::class]),
  Scenarios([HeaderScenarios::class]),
]
class Header implements CommonObjectInterface {

  use ObjectTrait;

  protected ?SearchForm $search;

  /**
   * @phpstan-param \Ramsey\Collection\CollectionInterface<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree> $menu
   * @phpstan-param \Ramsey\Collection\CollectionInterface<\PreviousNext\Ds\Common\Atom\Button\Button> $controls
   */
  final private function __construct(
    protected LinkedImage $logo,
    protected ?string $title,
    protected ?string $description,
    protected bool $hasSearch,
    protected CollectionInterface $menu,
    protected CollectionInterface $controls,
  ) {
  }

  /**
   * Create a Header.
   *
   * Menu trees are passed in instead of Navigation component so DS can
   * initialise Navigation on its own.
   *
   * @phpstan-param iterable<CommonAtoms\Button\Button> $controls
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree> $menu
   */
  public static function create(
    LinkedImage $logo,
    ?string $title = NULL,
    ?string $description = NULL,
    bool $hasSearch = FALSE,
    iterable $menu = [],
    iterable $controls = [],
  ): static {
    return static::factoryCreate(
      logo: $logo,
      title: $title,
      description: $description,
      hasSearch: $hasSearch,
      menu: new Collection(\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree::class, \iterator_to_array($menu)),
      controls: new Collection(CommonAtoms\Button\Button::class, \iterator_to_array($controls)),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set(HeaderSlots::logo, $this->logo)
      ->set(HeaderSlots::title, $this->title)
      ->set(HeaderSlots::description, $this->description)
      ->set(HeaderSlots::navigation, NULL)
      ->set(HeaderSlots::search, $this->hasSearch ? SearchForm::create('/search-for-common') : NULL)
      ->set(HeaderSlots::controls, $this->controls->map(static fn (CommonAtoms\Button\Button $button): mixed => $button())->toArray());
  }

}
