<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Modifier;

/**
 * Mutually exclusive indicator for enum.
 *
 * Attribute indicating cases of an enum may not be present alongside other
 * instances of the same enum.
 *
 * A MutexException will be thrown when:
 * - An enum with this attribute is added to a ModifierBag collection, AND
 * - An instance of the same enum/object is present.
 */
#[\Attribute(flags: \Attribute::TARGET_CLASS)]
final class Mutex {}
