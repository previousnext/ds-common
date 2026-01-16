<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare\Tests;

use PreviousNext\Ds\Common\Component\SocialShare\SocialShareSocialMediaInterface;

enum DemoSocialMedia implements SocialShareSocialMediaInterface {

  case Digg;
  case Slashdot;
  case MySpace;
  case Odeo;
  case LastFm;

}
