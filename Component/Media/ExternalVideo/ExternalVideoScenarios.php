<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Media\ExternalVideo;

final class ExternalVideoScenarios {

  public static function externalVideo(): ExternalVideo {
    return ExternalVideo::create(
      'https://www.youtube.com/watch?v=QrGrOK8oZG8',
      'Too Many Cooks 👨‍🍳',
      671,
    );
  }

}
