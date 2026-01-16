<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;

#[ObjectType\Slots(slots: [
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
class SocialShare implements Utility\CommonObjectInterface, \Countable {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<SocialShareModifierInterface> $modifiers
   */
  private function __construct(
    public Attribute $containerAttributes,
    public Modifier\ModifierBag $modifiers,
  ) {
  }

  public static function create(): static {
    return static::factoryCreate(
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(SocialShareModifierInterface::class),
    );
  }

  /**
   * @phpstan-return $this
   */
  public function addSocialMedia(
    SocialShareSocialMediaInterface $socialMedia,
    Url $url,
  ): static {
    $this->modifiers[] = new SocialMediaUrl($socialMedia, $url);

    return $this;
  }

  protected function build(Slots\Build $build): Slots\Build {
    foreach ($this->modifiers->getInstancesOf(SocialMediaUrl::class) as $socialMedia) {
      $build->set($socialMedia->socialMedia, $socialMedia->url->toString());
    }
    return $build;
  }

  public function count(): int {
    return \count($this->modifiers->getInstancesOf(SocialMediaUrl::class));
  }

}
