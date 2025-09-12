<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Sidebar;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'content',
  'sidebar',
  'sidebarPosition',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
  new Slots\Slot('contentAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'contentAttributes'),
  new Slots\Slot('sidebarAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'sidebarAttributes'),
])]
#[Scenarios([SidebarScenarios::class])]
class Sidebar implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    // @todo adapt $content to whats convenient for LB/other content.
    protected Atom\Html\Html $content,
    // @todo adapt $sidebar to whats convenient for LB/other content.
    protected Atom\Html\Html $sidebar,
    protected Position $position,
    public Attribute $containerAttributes,
    public Attribute $contentAttributes,
    public Attribute $sidebarAttributes,
  ) {}

  public static function create(
    Atom\Html\Html $content,
    Atom\Html\Html $sidebar,
    Position $position,
  ): static {
    return static::factoryCreate(
      content: $content,
      sidebar: $sidebar,
      position: $position,
      containerAttributes: new Attribute(),
      contentAttributes: new Attribute(),
      sidebarAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('content', $this->content)
      ->set('sidebar', $this->sidebar)
      ->set('sidebarPosition', $this->position === Position::Start);
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->containerAttributes = clone $this->containerAttributes;
    $this->contentAttributes = clone $this->contentAttributes;
    $this->sidebarAttributes = clone $this->sidebarAttributes;
  }

}
