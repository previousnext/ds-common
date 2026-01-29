<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\HeroSearch;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<mixed>
 */
#[Scenarios([HeroSearchScenarios::class])]
#[ObjectType\Slots(slots: [
  'title',
  'content',
  'subtitle',
  'image',
  'links',
  'search',
  'modifiers',
  'containerAttributes',
])]
class HeroSearch extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<HeroSearchModifierInterface> $modifiers
   */
  final private function __construct(
    public Atom\Heading\Heading $title,
    public ?string $subtitle,
    public ?Component\Media\Image\Image $image,
    public ?Component\LinkList\LinkList $links,
    public ?Component\SearchForm\SearchForm $searchForm,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {
    parent::__construct();
  }

  public static function create(
    Atom\Heading\Heading|string $title,
    ?string $subtitle = NULL,
    ?Component\Media\Image\Image $image = NULL,
    ?Component\LinkList\LinkList $links = NULL,
    Component\SearchForm\SearchForm|string|null $searchFormOrActionUrl = NULL,
  ): static {
    return static::factoryCreate(
      title: \is_string($title) ? Atom\Heading\Heading::create($title, Atom\Heading\HeadingLevel::One) : $title,
      subtitle: $subtitle,
      image: $image,
      links: $links,
      searchForm: \is_string($searchFormOrActionUrl) ? Component\SearchForm\SearchForm::create($searchFormOrActionUrl) : $searchFormOrActionUrl,
      modifiers: new Modifier\ModifierBag(HeroSearchModifierInterface::class),
      containerAttributes: new Attribute(),
    );
  }

  public function getType(): string {
    return 'mixed';
  }

}
