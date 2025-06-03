<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Footer;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Atom\LinkedImage\LinkedImage;
use PreviousNext\Ds\Common\Component\SocialLinks\SocialLinks;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\Ds\Common\Vo\MenuTree\MenuTrees;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([FooterScenarios::class])]
#[\Pinto\Attribute\ObjectType\Slots(slots: [
  'logo',
  'navigation',
  'links',
  'socials',
  'modifiers',
  'containerAttributes',
  'description',
  'copyright',
])]
class Footer implements CommonObjectInterface {

  use ObjectTrait;

  /**
   * Constructs a Footer.
   *
   * A description can be an Acknowledgment of Country (AOC), Slogan, or other short one-line blurb.
   *
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<\PreviousNext\Ds\Common\Layout\Footer\FooterModifierInterface> $modifiers
   */
  final private function __construct(
    public readonly LinkedImage $logo,
    protected readonly ?string $description,
    protected readonly ?string $copyright,
    protected MenuTrees $menu,
    protected Atom\Link\Links $links,
    protected ?SocialLinks $socialLinks,
    public Modifier\ModifierBag $modifiers,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    LinkedImage $logo,
    ?string $description = NULL,
    ?string $copyright = NULL,
    ?MenuTrees $menu = NULL,
    ?SocialLinks $socialLinks = NULL,
    ?Atom\Link\Links $links = NULL,
  ): static {
    return static::factoryCreate(
      logo: $logo,
      description: $description,
      copyright: $copyright,
      links: $links ?? new Atom\Link\Links(),
      menu: $menu ?? new MenuTrees(),
      socialLinks: $socialLinks,
      modifiers: new Modifier\ModifierBag(FooterModifierInterface::class),
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('links', $this->links->map(static fn (Atom\Link\Link $item): mixed => $item())->toArray());
  }

  public function __clone() {
    // Deep clone inner objects. This should be duplicated to other objects...
    $this->modifiers = clone $this->modifiers;
  }

}
