<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Url;

class Link {

  private function __construct(
    public Url $url,
  ) {
  }

  final public static function fromUrl(Url $url): static {
    return new static($url);
  }

  public function renderArray(): array {
    return ['#plain_text' => $this->url->toString()];
  }

}
