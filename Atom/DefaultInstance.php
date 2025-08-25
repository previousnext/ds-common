<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom;

/**
 * Would be 'Default' but it is reserved.
 *
 * @internal
 *   Unlike Empty, DefaultInstance should never be created. Instead, let a parameter default fall to creating this object.
 */
final class DefaultInstance implements Heading\HeadingInterface, Link\LinkInterface, Icon\IconInterface {

}
