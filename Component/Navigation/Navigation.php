<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Navigation;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree>
 */
#[ObjectType\Slots(slots: [
  'id',
  'title',
  'menuTrees',
])]
#[Scenarios([NavigationScenarios::class])]
class Navigation extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree> $menuTrees
   */
  final protected function __construct(
    private string $id,
    private string $title,
    iterable $menuTrees,
  ) {
    parent::__construct(data: \iterator_to_array($menuTrees));
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Vo\\MenuTree\\MenuTree';
  }

  /**
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree>|null $menuTrees
   */
  public static function create(
    string $id,
    string $title,
    ?iterable $menuTrees = NULL,
  ): static {
    return static::factoryCreate(
      $id,
      $title,
      $menuTrees ?? [],
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('id', $this->id)
      ->set('title', $this->title)
      ->set('menuTrees', $this->toArray());
  }

}
