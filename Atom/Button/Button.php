<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Button;

use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([ButtonScenarios::class])]
class Button implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<ButtonModifierInterface> $modifiers
   */
  final private function __construct(
    public string $title,
    public ?string $href,
    public ButtonType $as,
    public bool $disabled,
    public bool $iconOnly,
    public ?Atom\Icon\Icon $iconStart,
    public ?Atom\Icon\Icon $iconEnd,
    public Modifier\ModifierBag $modifiers,
  ) {}

  public static function create(
    string $title,
    ButtonType $as,
    ?string $href = NULL,
    bool $disabled = FALSE,
    bool $iconOnly = FALSE,
    ?Atom\Icon\Icon $iconStart = NULL,
    ?Atom\Icon\Icon $iconEnd = NULL,
  ): static {
    return static::factoryCreate(
      title: $title,
      href: $href,
      as: $as,
      disabled: $disabled,
      iconOnly: $iconOnly,
      iconStart: $iconStart,
      iconEnd: $iconEnd,
      modifiers: new Modifier\ModifierBag(ButtonModifierInterface::class),
    );
  }

}
