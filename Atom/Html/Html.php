<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Html;

use Drupal\Component\Render\MarkupInterface;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * Arbitrary HTML.
 *
 * @extends \Ramsey\Collection\AbstractCollection<mixed>
 */
#[ObjectType\Slots(slots: [
  'items',
])]
final class Html extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private function __construct(
    ?MarkupInterface $markup = NULL,
  ) {
    parent::__construct($markup !== NULL ? [$markup] : []);
  }

  public function getType(): string {
    return 'mixed';
  }

  public static function create(
    MarkupInterface $markup,
  ): static {
    return new static($markup);
  }

  /**
   * Call from other Common objects.
   *
   * @phpstan-param iterable<mixed> $collection
   * @internal
   */
  public static function createFromCollection(iterable $collection): static {
    $i = new static();
    \array_push($i->data, ...\iterator_to_array($collection));
    return $i;
  }

  protected function build(Slots\Build $build): Slots\Build {
    $markup = $this->map(static function (mixed $item): mixed {
      return \is_callable($item) ? ($item)() : $item;
    })->toArray();

    return $build
      ->set('items', $markup);
  }

}
