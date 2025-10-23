<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tabs;

use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Vo\Id\Id;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<mixed>
 */
final class Tab extends AbstractCollection {

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  private function __construct(
    public readonly Id $id,
    public readonly string $title,
    Atom\Html\Html|iterable|null $content,
  ) {
    if ($content !== NULL) {
      parent::__construct(\iterator_to_array($content));
    }
  }

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  public static function create(
    string $title,
    Atom\Html\Html|iterable|null $content = NULL,
  ): static {
    return new static(
      // Create the ID here so we can potentially use it before Tabs::build.
        id: Id::create(),
        title: $title,
        content: $content,
    );
  }

  public function getType(): string {
    return 'mixed';
  }

}
