<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare;

use Drupal\Core\Url;

final class SocialMediaUrl implements SocialShareModifierInterface {

  /**
   * @internal
   */
  public function __construct(
    public readonly SocialShareSocialMediaInterface $socialMedia,
    public readonly Url $url,
  ) {
  }

}
