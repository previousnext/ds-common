<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\HeroBanner;

use Drupal\Core\Template\Attribute;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([HeroBannerScenarios::class])]
class HeroBanner implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<HeroBannerModifierInterface> $modifiers
   */
  final private function __construct(
    public string $title,
    public string $subtitle,
    public ?Atom\Link\Link $link,
    public ?Component\Media\Image\Image $image,
    public ?Component\LinkList\LinkList $links,
    public bool $highlight,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {}

  public static function create(
    string $title,
    string $subtitle,
    ?Atom\Link\Link $link = NULL,
    // Maybe these should be their own variant of this object...
    ?Component\Media\Image\Image $image = NULL,
    ?Component\LinkList\LinkList $links = NULL,
  ): static {
    if ($image !== NULL && $links !== NULL) {
      throw new \LogicException(\sprintf('A `%s` object cannot have both $image and $links populated.', static::class));
    }

    return static::factoryCreate(
      $title,
      $subtitle,
      $link,
      $image,
      $links,
      highlight: TRUE,
      modifiers: new Modifier\ModifierBag(HeroBannerModifierInterface::class),
      containerAttributes: new Attribute(),
    );
  }

}
