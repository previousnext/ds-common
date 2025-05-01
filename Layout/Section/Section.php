<?php

declare(strict_types = 1);

namespace PreviousNext\Ds\Common\Layout\Section;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;

#[ObjectType\Slots(slots: [
  'background',
  'isContainer',
  'as',
  'heading',
  'content',
  'link',
  'modifiers',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
class Section {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<SectionModifierInterface> $modifiers
   */
  final private function __construct(
    protected SectionType $as,
    protected bool $isContainer,
    protected ?Component\Media\Image\Image $background,
    protected ?Atom\Heading\Heading $heading,
    protected ?Atom\Html\Html $content,
    protected ?Atom\Link\Link $link,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {}

  public static function create(
    SectionType $as,
    ?Component\Media\Image\Image $background = NULL,
    bool $isContainer = TRUE,
    ?string $heading = NULL,
    ?Atom\Html\Html $content = NULL,
    ?Atom\Link\Link $link = NULL,
  ): static {
    return static::factoryCreate(
      as: $as,
      isContainer: $isContainer,
      background: $background,
      heading: $heading ? Atom\Heading\Heading::create($heading) : NULL,
      content: $content,
      link: $link,
      modifiers: new Modifier\ModifierBag(SectionModifierInterface::class),
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('background', $this->background)
      ->set('isContainer', $this->isContainer)
      ->set('as', $this->as)
      ->set('heading', $this->heading)
      ->set('content', $this->content->markup)
      ->set('link', $this->link instanceof Atom\Link\LinkWithLabel ? $this->link->markup() : $this->link->url)
      ->set('modifiers', NULL)
    ;
  }

}
