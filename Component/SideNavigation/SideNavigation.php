<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SideNavigation;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTree;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTrees;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree>
 */
#[ObjectType\Slots(slots: [
  'id',
  'title',
  'menuTrees',
  'parentLink',
])]
#[Scenarios([SideNavigationScenarios::class])]
class SideNavigation extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private ?Atom\Link\Link $activeLink = NULL;

  /**
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree> $menuTrees
   */
  final protected function __construct(
    protected string $id,
    protected string $title,
    iterable $menuTrees,
    protected ?Atom\Link\Link $parentLink,
    public Attribute $containerAttributes,
  ) {
    parent::__construct(data: \iterator_to_array($menuTrees));
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Vo\\MenuTree\\MenuTree';
  }

  /**
   * Sets active link.
   *
   * The link may be located at any place in the tree.
   *
   * @phpstan-return $this
   */
  public function setActive(Atom\Link\Link $activeLink): static {
    $this->activeLink = $activeLink;

    return $this;
  }

  /**
   * Applies active.
   *
   * By default, will traverse the tree, ensuring the page and its direct parents are marked as active.
   *
   * @phpstan-return $this
   */
  protected function applyActive(): static {
    if ($this->activeLink === NULL) {
      return $this;
    }

    $top = $this->parentLink;
    if ($top === NULL) {
      $url = \Mockery::mock(Url::class);
      $url->expects('toString')->andReturn('http://example.com/');
      $top = Atom\Link\Link::create('Ignored link', $url);
    }

    $outer = MenuTree::create($top);
    foreach ($this as $m) {
      $outer[] = $m;
    }

    /** @var array<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree> $trail */
    $trail = [];
    $setTrail = $this->setActiveTrail(...);
    $activeLink = $this->activeLink;
    ($loop = static function (MenuTree $menuTree) use (&$loop, $activeLink, &$trail, $setTrail): void {
      $trail[] = $menuTree;

      if ($menuTree->link === $activeLink) {
        // If the link and activelink are the exact same object reference:
        $setTrail(new MenuTrees($trail));
        return;
      }

      foreach ($menuTree as $tree) {
        $loop($tree);
      }

      \array_pop($trail);
    })($outer);

    return $this;
  }

  /**
   * An active trail of menus trees.
   *
   * Typically, you'd want to set active on the overarching link on each menu tree.
   */
  protected function setActiveTrail(MenuTrees $links): void {
    foreach ($links as $link) {
      $link->link->current = TRUE;
    }
  }

  /**
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Vo\MenuTree\MenuTree>|null $menuTrees
   */
  public static function create(
    string $id,
    string $title,
    ?iterable $menuTrees = NULL,
    ?Atom\Link\Link $parentLink = NULL,
  ): static {
    return static::factoryCreate(
      $id,
      $title,
      $menuTrees ?? [],
      $parentLink,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    $this->applyActive();

    return $build;
  }

}
