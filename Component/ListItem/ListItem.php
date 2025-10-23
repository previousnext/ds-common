<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\ListItem;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom\Html\Html;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

use Ramsey\Collection\AbstractCollection;

/**
 * @extends AbstractCollection<mixed>
 */
#[Scenarios([ListItemScenarios::class])]
class ListItem extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * List item.
   *
   * $info and $infoPosition are for smaller text bumper against the link.
   * $label is another supplementary block of text.
   *
   * @phpstan-param Atom\Html\Html|iterable<mixed>|null $content
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<ListItemModifierInterface> $modifiers
   */
  final private function __construct(
    public Atom\Link\Link $link,
    public ?Component\Media\Image\Image $image,
    public Component\Tags\Tags $tags,
    Atom\Html\Html|iterable|null $content,
    public ?string $label,
    public ?string $info,
    public InfoPosition $infoPosition,
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
    Atom\Link\Link $link,
    ?Component\Media\Image\Image $image = NULL,
    ?Component\Tags\Tags $tags = NULL,
    Atom\Html\Html|iterable|null $content = NULL,
    ?string $label = NULL,
    ?string $info = NULL,
    InfoPosition $infoPosition = InfoPosition::None,
  ): static {
    return static::factoryCreate(
      link: $link,
      image: $image,
      tags: $tags ?? Component\Tags\Tags::create(),
      content: $content,
      label: $label,
      info: $info,
      infoPosition: $infoPosition,
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(ListItemModifierInterface::class),
    );
  }

  public function getType(): string {
    return 'mixed';
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('link', $this->link)
      ->set('content', Html::createFromCollection($this));
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->modifiers = clone $this->modifiers;
  }

}
