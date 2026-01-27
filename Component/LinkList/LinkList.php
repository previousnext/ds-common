<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\LinkList;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Atom\Link\Link>
 */
#[ObjectType\Slots(slots: [
  'title',
  'items',
  new Slots\Slot('modifier', defaultValue: NULL),
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([LinkListScenarios::class])]
class LinkList extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    array $links,
    public Attribute $containerAttributes,
    public ?Atom\Heading\Heading $title = NULL,
  ) {
    parent::__construct($links);
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\Common\\Atom\\Link\\Link';
  }

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Atom\Link\Link[] $links
   */
  public static function create(
    array $links = [],
    Atom\Heading\Heading|string|null $title = NULL,
  ): static {
    return static::factoryCreate(
      links: $links,
      containerAttributes: new Attribute(),
      title: \is_string($title) ? Atom\Heading\Heading::create($title, Atom\Heading\HeadingLevel::Two) : $title,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('items', $this->map(static fn (Atom\Link\Link $link): mixed => $link())->toArray())
      ->set('title', $this->title);
  }

  public static function fromLinks(Atom\Link\Links $links): static {
    return self::create($links->toArray());
  }

}
