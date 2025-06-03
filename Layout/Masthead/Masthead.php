<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Masthead;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[ObjectType\Slots(slots: [
  'content',
  'links',
  'background',
  'skipLinks',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([MastheadScenarios::class])]
class Masthead implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<MastheadModifierInterface> $modifiers
   */
  private function __construct(
    protected ?CommonAtoms\Html\Html $content,
    public CommonAtoms\Link\Links $links,
    public Attribute $containerAttributes,
    public Modifier\ModifierBag $modifiers,
    public CommonAtoms\Link\Links $skipLinks,
  ) {
  }

  /**
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Atom\Link\Link> $links
   * @phpstan-param iterable<\PreviousNext\Ds\Common\Atom\Link\Link> $skipLinks
   */
  public static function create(
    ?CommonAtoms\Html\Html $content = NULL,
    iterable $links = [],
    iterable $skipLinks = [],
  ): static {
    return static::factoryCreate(
      content: $content,
      links: new CommonAtoms\Link\Links(\iterator_to_array($links)),
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(MastheadModifierInterface::class),
      skipLinks: new CommonAtoms\Link\Links(\iterator_to_array($skipLinks)),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('content', $this->content?->markup)
      ->set('containerAttributes', $this->containerAttributes)
      ->set('links', $this->links->map(static fn (CommonAtoms\Link\Link $item): mixed => $item())->toArray())
      ->set('skipLinks', $this->links->map(static fn (CommonAtoms\Link\Link $item): mixed => $item())->toArray());
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->modifiers = clone $this->modifiers;
  }

}
