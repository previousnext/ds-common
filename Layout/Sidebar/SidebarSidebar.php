<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Sidebar;

use Drupal\Core\Template\Attribute;
use Ramsey\Collection\AbstractCollection;

/**
 * @internal
 * @extends \Ramsey\Collection\AbstractCollection<mixed>
 */
final class SidebarSidebar extends AbstractCollection {

  final private function __construct(
    public Attribute $sidebarAttributes,
  ) {
    parent::__construct();
  }

  /**
   * @internal
   *   For exclusive use by Sidebar.
   */
  public static function create(): static {
    return new static(
      sidebarAttributes: new Attribute(),
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->sidebarAttributes = clone $this->sidebarAttributes;
  }

}
