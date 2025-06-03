<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialLinks\SocialLink;

use PreviousNext\Ds\Common\Atom;

final class SocialLink {

  private function __construct(
    private Atom\LinkedImage\LinkedImage|Atom\Link\Link $linkedImageOrLink,
  ) {
  }

  public static function fromLink(Atom\Link\Link $link): static {
    return new static($link);
  }

  public static function fromLinkedImage(Atom\LinkedImage\LinkedImage $linkedImage): static {
    return new static($linkedImage);
  }

  /**
   * @phpstan-return mixed
   */
  public function __invoke() {
    return ($this->linkedImageOrLink)();
  }

}
