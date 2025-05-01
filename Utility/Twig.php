<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Utility;

use PreviousNext\Ds\Common\Component;

/**
 * @internal
 */
final class Twig {

  public const Namespace = 'pnx-common';

  public static function computePathFromDrupalRootTo(string $path): string {
    $fromParts = explode(DIRECTORY_SEPARATOR, realpath(\DRUPAL_ROOT));
    $toParts = explode(DIRECTORY_SEPARATOR, realpath($path));

    // Find the common base directory
    $commonLength = 0;
    while (isset($fromParts[$commonLength]) && isset($toParts[$commonLength]) && $fromParts[$commonLength] === $toParts[$commonLength]) {
      $commonLength++;
    }

    // Join steps to get the relative path
    return implode(DIRECTORY_SEPARATOR, [
      // Up.
      ...\array_fill(0, count($fromParts) - $commonLength, '..'),
      // Down.
      ...array_slice($toParts, $commonLength),
    ]);
  }

}
