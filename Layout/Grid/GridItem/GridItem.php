<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Grid\GridItem;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<mixed>
 */
#[ObjectType\Slots(slots: [
  'content',
  'isContainer',
  'modifiers',
  'as',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
class GridItem extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<GridItemModifierInterface> $modifiers
   */
  final private function __construct(
    protected GridItemType $as,
    protected bool $isContainer,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {
    parent::__construct();
  }

  public static function create(
    GridItemType $as,
    bool $isContainer = TRUE,
  ): static {
    return static::factoryCreate(
      $as,
      $isContainer,
      new Modifier\ModifierBag(GridItemModifierInterface::class),
      new Attribute(),
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  protected function build(Slots\Build $build): Slots\Build {
    $content = $this->map(static function (mixed $item): mixed {
      return \is_callable($item) ? ($item)() : $item;
    })->toArray();

    return $build
      ->set('content', $content)
      ->set('isContainer', $this->isContainer)
      ->set('as', $this->as)
      ->set('modifiers', NULL);
  }

}
