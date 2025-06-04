<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\ListItem;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([ListItemScenarios::class])]
class ListItem implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * List item.
   *
   * $info and $infoPosition are for smaller text bumper against the link.
   * $label is another supplementary block of text.
   *
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<ListItemModifierInterface> $modifiers
   */
  final private function __construct(
    public Atom\Link\Link $link,
    public ?Component\Media\Image\Image $image,
    public Atom\Tag\Tags $tags,
    public ?Atom\Html\Html $content,
    public ?string $label,
    public ?string $info,
    public InfoPosition $infoPosition,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    Atom\Link\Link $link,
    ?Component\Media\Image\Image $image = NULL,
    ?Atom\Tag\Tags $tags = NULL,
    ?Atom\Html\Html $content = NULL,
    ?string $label = NULL,
    ?string $info = NULL,
    InfoPosition $infoPosition = InfoPosition::None,
  ): static {
    return static::factoryCreate(
      link: $link,
      image: $image,
      tags: $tags ?? new Atom\Tag\Tags(),
      content: $content,
      label: $label,
      info: $info,
      infoPosition: $infoPosition,
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(ListItemModifierInterface::class),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('link', $this->link)
      ->set('content', $this->content?->markup);
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->modifiers = clone $this->modifiers;
  }

}
