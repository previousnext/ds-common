<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom\Heading\Heading;
use PreviousNext\Ds\Common\Component\Tabs\TabItem\TabItem;
use PreviousNext\Ds\Common\Component\Tabs\TabListItem\TabListItem;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractSet;

/**
 * @extends \Ramsey\Collection\AbstractSet<\PreviousNext\Ds\Common\Component\Tabs\Tab>
 */
#[ObjectType\Slots(slots: [
  'id',
  'title',
  'listItems',
  'items',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([TabsScenarios::class])]
class Tabs extends AbstractSet implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private function __construct(
    protected Heading $title,
    public Attribute $containerAttributes,
    protected ?Tab $active = NULL,
    protected readonly ?string $id = NULL,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Component\\Tabs\\Tab';
  }

  public static function create(
    string $title,
    ?string $id = NULL,
  ): static {
    return static::factoryCreate(
      Heading::create($title),
      containerAttributes: new Attribute(),
      id: $id,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    // If nothing was delegated as active by now, set first to active.
    if ($this->active === NULL) {
      $this->active = $this->first();
    }

    /** @var array<array{TabListItem, TabItem}> $tabs */
    $tabs = $this->map(function (Tab $item): array {
      return [
        (TabListItem::create((string) $item->id, $item->title, $this->active === $item))(),
        (TabItem::create((string) $item->id, $item->title, $item->content))(),
      ];
    })->toArray();

    return $build
      ->set('id', $this->id)
      ->set('title', $this->title->heading)
      ->set('listItems', \array_column($tabs, 0))
      ->set('items', \array_column($tabs, 1));
  }

  public function setActive(Tab $tab): void {
    if (FALSE === $this->contains($tab)) {
      throw new \InvalidArgumentException('Cant set active tab when it does not exist in this tab collection.');
    }

    $this->active = $tab;
  }

  /**
   * @phpstan-return $this
   */
  public function addSimple(
    string $title,
    string $content,
  ) {
    $this[] = Tab::create($title, $content);
    return $this;
  }

}
