<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Utility;

#[\Attribute(flags: \Attribute::TARGET_CLASS_CONSTANT)]
final class TemplateDirectory {

  /**
   * Construct a custom template location.
   */
  public function __construct(public string $path) {}

}
