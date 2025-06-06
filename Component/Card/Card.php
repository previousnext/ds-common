<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Card;

use Drupal\block_content\BlockContentInterface;
use Drupal\Core\Template\Attribute;
use Drupal\pinto_block\BlockBundleInterface;
use Drupal\pinto_block\ObjectContextInterface;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\BundleClass;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

/**
 * @method array{'#image': array{'#height': int}} __invoke()
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
class Card implements Utility\CommonObjectInterface, BlockBundleInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param Modifier\ModifierBag<\PreviousNext\Ds\Common\Component\Card\CardModifierInterface> $modifiers
   */
  final private function __construct(
    public ?CommonComponents\Media\Image\Image $image,
    public ?Atom\Icon\Icon $icon,
    public ?\DateTimeInterface $date,
    public CommonComponents\LinkList\LinkList $links,
    public Atom\Tag\Tags $tags,
    public ?Atom\Heading\Heading $heading,
    public ?Atom\Html\Html $content,
    public ?Atom\Link\Link $link,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {}

  public static function create(
    ?CommonComponents\Media\Image\Image $image,
    ?CommonComponents\LinkList\LinkList $links,
    ?\DateTimeInterface $date = NULL,
    ?Atom\Icon\Icon $icon = NULL,
    ?Atom\Tag\Tags $tags = NULL,
    ?Atom\Heading\Heading $heading = NULL,
    ?Atom\Html\Html $content = NULL,
    ?Atom\Link\Link $link = NULL,
    ?iterable $modifiers = [],
  ): static {
    $modifierBag = new Modifier\ModifierBag(CardModifierInterface::class, \iterator_to_array($modifiers));
    return static::factoryCreate(
      image: $image,
      icon: $icon,
      date: $date,
      links: $links ?? CommonComponents\LinkList\LinkList::create(),
      tags: $tags ?? new Atom\Tag\Tags(),
      heading: $heading,
      content: $content,
      link: $link,
      modifiers: $modifierBag,
      containerAttributes: new Attribute(),
    );
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
      tags: new Atom\Tag\Tags(),
      // @todo heading.
      heading: NULL,
      // @todo content.
      content: NULL,
      // @todo link.
      link: NULL,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    // This is built in Common since there is a shared benefit from
    // functionality of a common interface.
    foreach ($this->modifiers as $modifier) {
      $this->containerAttributes->addClass($modifier->className());
    }
    return $build
      ->set('containerAttributes', $this->containerAttributes);
  }

  public static function createForLayoutBuilderBlockContent(BlockContentInterface $blockContent, ObjectContextInterface $objectContext): static {
    \assert($blockContent instanceof BundleClass\BlockContent\Card\CardBundle);
    return static::createFrom($blockContent);
  }

}
