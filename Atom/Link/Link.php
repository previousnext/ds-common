<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom\DefaultInstance;
use PreviousNext\Ds\Common\Atom\Icon\IconInterface;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios(scenarios: [
  LinkScenarios::class,
])]
class Link implements CommonObjectInterface, LinkInterface {

  use ObjectTrait;

  final private function __construct(
    public string $title,
    public string $href,
    public bool $more,
    public bool $external,
    public bool $current,
    public bool $download,
    public IconInterface $iconStart,
    public IconInterface $iconEnd,
    public Attribute $attributes,
  ) {
  }

  final public static function create(
    string $title,
    Url $url,
    bool $more = FALSE,
    bool $external = FALSE,
    bool $current = FALSE,
    bool $download = FALSE,
    IconInterface $iconStart = new DefaultInstance(),
    IconInterface $iconEnd = new DefaultInstance(),
  ): static {
    return static::factoryCreate(
      title: $title,
      href: $url->toString(),
      more: $more,
      external: $external,
      current: $current,
      download: $download,
      iconStart: $iconStart,
      iconEnd: $iconEnd,
      attributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('iconStart', $this->iconStart instanceof self ? $this->iconStart : NULL)
      ->set('iconEnd', $this->iconEnd instanceof self ? $this->iconEnd : NULL);
  }

}
