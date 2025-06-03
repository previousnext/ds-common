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

}
