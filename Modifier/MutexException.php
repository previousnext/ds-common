<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier;

final class MutexException extends \Exception {


  public static function create(
    \UnitEnum $existingEnum,
    \UnitEnum $enum,
  ) {
    return new static(message: sprintf('Cannot add %s::%s to a %s since an enum of the same type already exists in this bag: %s::%s. This happens since %s has been designated as mutually exclusive with the %s attribute.', $enum::class, $enum->name, ModifierBag::class, $existingEnum::class, $existingEnum->name, $enum::class, Mutex::class));
  }

}
