<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid\GridItem;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;

#[ObjectType\Slots(slots: [
  'item',
  'isContainer',
  'modifiers',
  'as',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
class GridItem implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<\PreviousNext\Ds\Common\Layout\Grid\GridModifierInterface> $modifiers
   */
  final private function __construct(
    // Should this accept anything? auto-exec objs?
    // protected Atom\Html\Html $item,.
    protected mixed $item,
    protected GridItemType $as,
    protected bool $isContainer,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {}

  /**
   * @phpstan-param array<object|array<string, mixed>> $item
   */
  public static function create(
    // Atom\Html\Html $item,.
    mixed $item,
    GridItemType $as,
    bool $isContainer = TRUE,
  ): static {
    return static::factoryCreate(
      $item,
      $as,
      $isContainer,
      new Modifier\ModifierBag(GridItemModifierInterface::class),
      new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      // Remove HTML hard case.
      ->set('item', [$this->item instanceof Atom\Html\Html ? $this->item->markup : $this->item])
      ->set('isContainer', $this->isContainer)
      ->set('as', $this->as)
      ->set('modifiers', NULL);
  }

}
