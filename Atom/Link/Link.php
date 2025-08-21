<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom\Icon\Icon;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios(scenarios: [
  LinkScenarios::class,
])]
class Link implements CommonObjectInterface {

  use ObjectTrait;

  final private function __construct(
    public string $title,
    public string $href,
    public bool $more,
    public bool $external,
    public bool $current,
    public bool $download,
    public ?Icon $iconStart,
    public ?Icon $iconEnd,
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
    ?Icon $iconStart = NULL,
    ?Icon $iconEnd = NULL,
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

}
