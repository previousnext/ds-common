<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Sidebar;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom\Html\Html;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<mixed>
 */
#[ObjectType\Slots(slots: [
  'content',
  'sidebar',
  'sidebarPosition',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
  new Slots\Slot('contentAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'contentAttributes'),
  new Slots\Slot('sidebarAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'sidebarAttributes'),
])]
#[Scenarios([SidebarScenarios::class])]
class Sidebar extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  public Attribute $sidebarAttributes;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<SidebarModifierInterface> $modifiers
   */
  final private function __construct(
    // Note, externals are not allowed to replace the Sidebar object with a new one, as we need
    // to maintain the connection of $sidebarAttributes and potentially other intertwined state.
    public SidebarSidebar $sidebar,
    public Position $position,
    public Attribute $containerAttributes,
    public Attribute $contentAttributes,
    public Modifier\ModifierBag $modifiers,
  ) {
    parent::__construct();

    // Use same reference as the sidebar object.
    // We could probably turn this into a ghost if >= PHP 8.4.
    $this->sidebarAttributes = $this->sidebar->sidebarAttributes;
  }

  public function getType(): string {
    return 'mixed';
  }

  public static function create(
    Position $position,
  ): static {
    $sidebar = SidebarSidebar::create();
    return static::factoryCreate(
      sidebar: $sidebar,
      position: $position,
      containerAttributes: new Attribute(),
      contentAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(SidebarModifierInterface::class),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('content', Html::createFromCollection($this->data))
      ->set('sidebar', Html::createFromCollection($this->sidebar->data))
      ->set('sidebarPosition', $this->position === Position::Start);
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->sidebar = clone $this->sidebar;
    $this->sidebarAttributes = $this->sidebar->sidebarAttributes;
    $this->containerAttributes = clone $this->containerAttributes;
    $this->contentAttributes = clone $this->contentAttributes;
  }

}
