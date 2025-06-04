<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Vo\Id;

use Drupal\Component\Utility\Html;

final class Id {

  private string $id;

  public function __construct() {
  }

  public static function create(): static {
    return new static();
  }

  public function __toString(): string {
    return $this->id ??= Html::getUniqueId('id');
  }

  /**
   * Fixes IDs conflicting/producing different IDs in the `ids dump:build-objects` command.
   *
   * This really needs to change, either with our own ID generator not relying on Drupal.
   */
  public static function resetGlobalState(): void {
    $html = new \ReflectionClass(Html::class);
    $html->getProperty('seenIdsInit')->setValue(NULL, []);
    $html->getProperty('classes')->setValue(NULL, []);
    $html->getProperty('seenIds')->setValue(NULL, []);
  }

}
