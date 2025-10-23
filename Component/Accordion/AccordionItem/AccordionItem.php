<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Accordion\AccordionItem;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom\Html\Html;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * @see \PreviousNext\Ds\Common\Component\Accordion\Accordion
 * @extends AbstractCollection<mixed>
 */
class AccordionItem extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  final private function __construct(
    public string $title,
    Atom\Html\Html|iterable|null $content,
    public bool $open,
    public ?string $id,
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
    string $title,
    Atom\Html\Html|iterable|null $content = NULL,
    ?bool $open = NULL,
    ?string $id = NULL,
  ): static {
    return static::factoryCreate(
      $title,
      $content,
      $open ?? TRUE,
      $id,
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
