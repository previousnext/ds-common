<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

final class CommonLists {

  /**
   * @var array<class-string<\Pinto\List\ObjectListInterface>>
   */
  public const Lists = [
    CommonAtoms::class,
    CommonComponents::class,
    CommonLayouts::class,
  ];

}
