<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Pagination;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component\Pagination\PaginationItem\PaginationItem;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Component\Pagination\PaginationItem\PaginationItem>
 */
#[ObjectType\Slots(slots: [
  new Slots\Slot('previous', fillValueFromThemeObjectClassPropertyWhenEmpty: 'previous'),
  new Slots\Slot('next', fillValueFromThemeObjectClassPropertyWhenEmpty: 'next'),
  'pages',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([PaginationScenarios::class])]
class Pagination extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \WeakReference<\PreviousNext\Ds\Common\Component\Pagination\PaginationItem\PaginationItem> $currentPage
   */
  private function __construct(
    public ?Atom\Link\Link $previous,
    public ?Atom\Link\Link $next,
    public Attribute $containerAttributes,
    protected \WeakReference|null $currentPage,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Component\\Pagination\\PaginationItem\\PaginationItem';
  }

  public static function create(
    ?Atom\Link\Link $previous = NULL,
    ?Atom\Link\Link $next = NULL,
  ): static {
    return static::factoryCreate(
      previous: $previous,
      next: $next,
      containerAttributes: new Attribute(),
      currentPage: NULL,
    );
  }

  /**
   * @phpstan-return $this
   */
  public function setActivePage(PaginationItem $paginationItem): static {
    $this->currentPage = \WeakReference::create($paginationItem);

    return $this;
  }

  protected function build(Slots\Build $build): Slots\Build {
    $currentPage = $this->currentPage?->get();
    if ($currentPage !== NULL) {
      if (FALSE === $this->contains($currentPage)) {
        throw new \InvalidArgumentException('Cant set current page as it does not exist in this steps collection.');
      }

      foreach ($this->data as $paginationItem) {
        $paginationItem->isEnabled = $currentPage === $paginationItem;
      }
    }

    return $build
      ->set('pages', $this->map(static fn (PaginationItem $item): mixed => $item())->toArray());
  }

}
