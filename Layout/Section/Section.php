<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Section;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Layout\Section\SectionItem>
 */
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
#[Scenarios([SectionScenarios::class])]
class Section extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<SectionModifierInterface> $modifiers
   */
  final private function __construct(
    public SectionType $as,
    public bool $isContainer,
    public ?Component\Media\Image\Image $background,
    public ?Atom\Heading\Heading $heading,
    public ?Atom\Link\Link $link,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Layout\\Section\\SectionItem';
  }

  public static function create(
    SectionType $as,
    ?Component\Media\Image\Image $background = NULL,
    bool $isContainer = TRUE,
    ?string $heading = NULL,
    ?Atom\Link\Link $link = NULL,
  ): static {
    return static::factoryCreate(
      as: $as,
      isContainer: $isContainer,
      background: $background,
      heading: $heading !== NULL ? Atom\Heading\Heading::create($heading, \PreviousNext\Ds\Common\Atom\Heading\HeadingLevel::Two) : NULL,
      link: $link,
      modifiers: new Modifier\ModifierBag(SectionModifierInterface::class),
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    $content = $this->map(static function (SectionItem $item): mixed {
      return \is_callable($item->content) ? ($item->content)() : $item->content;
    })->toArray();

    return $build
      ->set('background', $this->background)
      ->set('isContainer', $this->isContainer)
      ->set('as', $this->as)
      ->set('heading', $this->heading)
      ->set('content', $content)
      ->set('link', $this->link)
      ->set('modifiers', NULL);
  }

  /**
   * @phpstan-param mixed $value
   */
  public function offsetSet(mixed $offset, mixed $value): void {
    if (!$value instanceof SectionItem) {
      $value = SectionItem::create($value);
    }

    parent::offsetSet($offset, $value);
  }

}
