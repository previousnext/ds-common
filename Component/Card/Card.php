<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<mixed>
 */
#[ObjectType\Slots(slots: [
  'image',
  'icon',
  'links',
  'date',
  'tags',
  'heading',
  'content',
  'link',
  'modifiers',
  'containerAttributes',
])]
#[Scenarios([CardScenarios::class])]
class Card extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   * @phpstan-param Modifier\ModifierBag<\PreviousNext\Ds\Common\Component\Card\CardModifierInterface> $modifiers
   */
  final private function __construct(
    public ?CommonComponents\Media\Image\Image $image,
    public ?Atom\Icon\Icon $icon,
    public ?\DateTimeInterface $date,
    public CommonComponents\LinkList\LinkList $links,
    public CommonComponents\Tags\Tags $tags,
    public ?Atom\Heading\Heading $heading,
    Atom\Html\Html|iterable|null $content,
    public ?Atom\Link\Link $link,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {
    if ($content !== NULL) {
      parent::__construct(\iterator_to_array($content));
    }
  }

  /**
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   */
  public static function create(
    ?CommonComponents\Media\Image\Image $image,
    ?CommonComponents\LinkList\LinkList $links,
    ?\DateTimeInterface $date = NULL,
    ?Atom\Icon\Icon $icon = NULL,
    ?CommonComponents\Tags\Tags $tags = NULL,
    ?Atom\Heading\Heading $heading = NULL,
    Atom\Html\Html|iterable|null $content = NULL,
    ?Atom\Link\Link $link = NULL,
  ): static {
    return static::factoryCreate(
      image: $image,
      icon: $icon,
      date: $date,
      links: $links ?? CommonComponents\LinkList\LinkList::create(),
      tags: $tags ?? CommonComponents\Tags\Tags::create(),
      heading: $heading,
      content: $content,
      link: $link,
      modifiers: new Modifier\ModifierBag(CardModifierInterface::class),
      containerAttributes: new Attribute(),
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  public static function createFrom(CardDataInterface $data): static {
    $image = $data->getCardImage();
    // @todo heading, content, link, modifier
    return static::create(
      image: $image !== NULL ? CommonComponents\Media\Image\Image::fromImageMedia($image) : NULL,
      icon: NULL,
      date: $data->getCardDate(),
      // @todo handle Tags.
      links: CommonComponents\LinkList\LinkList::fromLinks($data->getLinks()),
      // @todo handle Icon.
      tags: CommonComponents\Tags\Tags::create(),
      // @todo heading.
      heading: NULL,
      // @todo content.
      content: NULL,
      // @todo link.
      link: NULL,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('containerAttributes', $this->containerAttributes);
  }

}
