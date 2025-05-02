<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Accordion;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Component\Accordion\AccordionItem\AccordionItem>
 */
#[ObjectType\Slots(slots: [
  'items',
  'title',
  new Slots\Slot('toggleAll', defaultValue: NULL),
  new Slots\Slot('modifier', defaultValue: NULL),
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
class Accordion extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private function __construct(
    protected string $title,
    public Attribute $containerAttributes,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\Common\\Component\\Accordion\\AccordionItem\\AccordionItem';
  }

  public static function create(
    string $title,
  ): static {
    return static::factoryCreate(
      $title,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('items', $this->map(static fn (AccordionItem\AccordionItem $item): mixed => $item())->toArray());
  }

  /**
   * @phpstan-return $this
   */
  public function addSimple(
    string $title,
    string $content,
  ) {
    $this[] = AccordionItem\AccordionItem::create($title, $content);
    return $this;
  }

}
