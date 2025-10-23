<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Steps\Step;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom\Html\Html;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * @see \PreviousNext\Ds\Common\Component\Steps\Steps
 * @extends AbstractCollection<mixed>
 */
class Step extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * Constructs a Step.
   *
   * The `enabled` flag is typically controlled by the containing Steps object.
   *
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  final private function __construct(
    Atom\Html\Html|iterable|null $content,
    public bool $isEnabled,
  ) {
    if ($content !== NULL) {
      parent::__construct(\iterator_to_array($content));
    }
  }

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  #[ObjectType\Slots(bindPromotedProperties: TRUE)]
  public static function create(
    Atom\Html\Html|iterable|null $content = NULL,
  ): static {
    return static::factoryCreate(
      content: $content,
      isEnabled: FALSE,
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('content', Html::createFromCollection($this));
  }

}
