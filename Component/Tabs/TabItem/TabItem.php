<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs\TabItem;

use Pinto\Attribute\ObjectType\Slots;
use Pinto\Slots\Build;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom\Html\Html;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * A TabItem are the tab contents.
 *
 * @see \PreviousNext\Ds\Common\Component\Tabs\Tabs
 * @extends AbstractCollection<mixed>
 */
class TabItem extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  final private function __construct(
    // Title is?
    public string $title,
    Atom\Html\Html|iterable|null $content,
    public string $id,
  ) {
    if ($content !== NULL) {
      parent::__construct(\iterator_to_array($content));
    }
  }

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  #[Slots(bindPromotedProperties: TRUE)]
  public static function create(
    string $id,
    string $title,
    Atom\Html\Html|iterable|null $content = NULL,
  ): static {
    return static::factoryCreate(
      title: $title,
      content: $content,
      id: $id,
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  protected function build(Build $build): Build {
    return $build
      ->set('content', Html::createFromCollection($this));
  }

}
