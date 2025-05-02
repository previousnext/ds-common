<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Link;

use Drupal\Core\Render\Markup;
use Drupal\Core\Template\Attribute;
use Drupal\Core\Url;

final class LinkWithLabel extends Link {

  public Attribute $aAttributes;

  private function __construct(
    public Url $url,
    public string $label,
  ) {
    $this->aAttributes = new Attribute();
  }

  final public static function fromLabelAndUrl(string $label, Url $url): static {
    return new static($url, $label);
  }

  public function markup(): Markup {
    return Markup::create(\sprintf('<a href="%s"%s>%s</a>', $this->url->toString(), (string) $this->aAttributes, $this->label));
  }

  public function renderArray(): array {
    return ['#markup' => $this->markup()];
  }

}
