<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Layout\Grid\GridItem\GridItem>
 */
#[ObjectType\Slots(slots: [
  'items',
  'modifiers',
  'as',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([GridScenarios::class])]
class Grid extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param GridItem\GridItemType $gridItemDefaultType
   *   When a non-GridItem is appended, it will receive this type. This type has
   *   no effect when a GridItem is directly appended.
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<GridModifierInterface> $modifiers
   */
  final private function __construct(
    protected GridType $as,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
    private GridItem\GridItemType $gridItemDefaultType,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\Common\\Layout\\Grid\\GridItem\\GridItem';
  }

  public static function create(
    GridType $as,
    GridItem\GridItemType $gridItemDefaultType = GridItem\GridItemType::Div,
  ): static {
    return static::factoryCreate(
      $as,
      new Modifier\ModifierBag(GridModifierInterface::class),
      containerAttributes: new Attribute(),
      gridItemDefaultType: $gridItemDefaultType,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('items', $this->map(static fn (GridItem\GridItem $item): mixed => $item())->toArray())
      ->set('modifiers', NULL)
      ->set('as', NULL);
  }

  public function offsetSet(mixed $offset, mixed $value): void {
    if (!$value instanceof GridItem\GridItem) {
      // Wrap everything in a GridItem:
      $value = GridItem\GridItem::create(
        item: $value,
        as: $this->gridItemDefaultType,
      );
    }

    parent::offsetSet($offset, $value);
  }

}
