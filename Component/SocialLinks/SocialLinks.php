<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialLinks;

use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component\SocialLinks\SocialLink\SocialLink;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractSet;

/**
 * @extends \Ramsey\Collection\AbstractSet<\PreviousNext\Ds\Common\Component\SocialLinks\SocialLink\SocialLink>
 */
#[ObjectType\Slots(slots: [
  'heading',
  'items',
])]
#[Scenarios([SocialLinksScenarios::class])]
class SocialLinks extends AbstractSet implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private function __construct(
    protected Atom\Heading\Heading $title,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Component\\SocialLinks\\SocialLink\\SocialLink';
  }

  public static function create(
    string $title,
  ): static {
    return static::factoryCreate(
      Atom\Heading\Heading::create($title, Atom\Heading\HeadingLevel::Two),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->title)
      ->set('items', $this->map(static fn (SocialLink $item): mixed => $item())->toArray());
  }

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Component\SocialLinks\SocialLink\SocialLink|Atom\LinkedImage\LinkedImage|Atom\Link\Link $value
   */
  public function offsetSet(mixed $offset, mixed $value): void {
    if ($value instanceof Atom\LinkedImage\LinkedImage) {
      $value = SocialLink::fromLinkedImage($value);
    }
    elseif ($value instanceof Atom\Link\Link) {
      $value = SocialLink::fromLink($value);
    }

    parent::offsetSet($offset, $value);
  }

}
