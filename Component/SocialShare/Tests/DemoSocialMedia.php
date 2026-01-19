<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare\Tests;

use Drupal\Core\Url;
use PreviousNext\Ds\Common\Component\SocialShare\SocialShareSocialMediaInterface;

enum DemoSocialMedia implements SocialShareSocialMediaInterface {

  case Digg;
  case Slashdot;
  case MySpace;
  case Odeo;
  case LastFm;

  public function defaultUrl(): ?Url {
    return match ($this) {
      static::Digg => Url::fromUri(\sprintf('https://digg.com/submit?url=%s', Url::fromRoute('<current>')->toString())),
      default => NULL,
    };
  }

}
