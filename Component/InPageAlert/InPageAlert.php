<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\InPageAlert;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<mixed>
 */
#[ObjectType\Slots(slots: [
  'heading',
  'type',
  'content',
  'link',
])]
#[Scenarios([InPageAlertScenarios::class])]
class InPageAlert extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  final private function __construct(
    protected Atom\Heading\Heading $heading,
    protected Type $type,
    Atom\Html\Html|iterable|null $content,
    protected ?Atom\Link\Link $link,
  ) {
    if ($content !== NULL) {
      parent::__construct(\iterator_to_array($content));
    }
  }

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  public static function create(
    Atom\Heading\Heading $heading,
    Type $type,
    Atom\Html\Html|iterable|null $content = NULL,
    ?Atom\Link\Link $link = NULL,
  ): static {
    return static::factoryCreate(
      heading: $heading,
      type: $type,
      content: $content,
      link: $link,
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->heading)
      ->set('type', $this->type->name)
      ->set('link', $this->link);
  }

}
