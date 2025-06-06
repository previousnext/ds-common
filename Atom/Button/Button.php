<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Button;

use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([ButtonScenarios::class])]
class Button implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    public string $title,
    public ?string $href,
    public ButtonType $as,
    public ?string $modifier,
    public bool $disabled,
    public bool $iconOnly,
    public ?Atom\Icon\Icon $iconStart,
    public ?Atom\Icon\Icon $iconEnd,
  ) {}

  public static function create(
    string $title,
    ButtonType $as,
    ?string $href = NULL,
    ?string $modifier = NULL,
    bool $disabled = FALSE,
    bool $iconOnly = FALSE,
    ?Atom\Icon\Icon $iconStart = NULL,
    ?Atom\Icon\Icon $iconEnd = NULL,
  ): static {
    if ($href !== NULL && $as !== ButtonType::Link) {
      throw new \LogicException(\sprintf('Buttons of type `%s::%s` should not have a `%s`', $as::class, $as->name, Atom\Link\Link::class));
    }

    return static::factoryCreate(
      $title,
      $href,
      $as,
      $modifier,
      $disabled,
      $iconOnly,
      $iconStart,
      $iconEnd,
    );
  }

}
