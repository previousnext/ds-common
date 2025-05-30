<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom\Icon\Icon;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

class Link implements CommonObjectInterface {

  use ObjectTrait;

  private function __construct(
    public string $title,
    public string $href,
    public bool $more = FALSE,
    public bool $external = FALSE,
    public bool $current = FALSE,
    public bool $download = FALSE,
    public ?Icon $iconStart = NULL,
    public ?Icon $iconEnd = NULL,
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
