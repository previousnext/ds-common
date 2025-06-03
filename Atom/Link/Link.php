<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom\Icon\Icon;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

class Link implements CommonObjectInterface {

  use ObjectTrait;

  private function __construct(
    public string $title,
    public string $href,
    public bool $more,
    public bool $external,
    public bool $current,
    public bool $download,
    public ?Icon $iconStart,
    public ?Icon $iconEnd,
    public Attribute $attributes = new Attribute(),
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
    return new static(
      $title,
      $url->toString(),
      $more,
      $external,
      $current,
      $download,
      $iconStart,
      $iconEnd,
    );
  }

}
