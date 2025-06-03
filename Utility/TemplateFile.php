<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Utility;

#[\Attribute(flags: \Attribute::TARGET_CLASS_CONSTANT)]
final class TemplateFile {

  /**
   * Construct a custom template file path without file extension.
   */
  public function __construct(public string $fileName) {}

}
