<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SocialShare;

use Drupal\Core\Url;

interface SocialShareSocialMediaInterface extends \UnitEnum {

  public function defaultUrl(): ?Url;

}
