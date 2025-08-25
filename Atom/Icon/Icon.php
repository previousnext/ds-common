<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Icon;

use Drupal\Core\Template\Attribute;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;

class Icon implements CommonObjectInterface, IconInterface {

  use ObjectTrait;

  /**
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<IconModifierInterface> $modifiers
   */
  final private function __construct(
    public string $icon,
    public ?string $text,
    public AlignmentType $alignmentType,
    public Attribute $containerAttributes,
    public Modifier\ModifierBag $modifiers,
  ) {
  }

  public static function create(
    string $icon = '',
    ?string $text = NULL,
    AlignmentType $alignmentType = AlignmentType::Default,
  ): static {
    return static::factoryCreate(
      $icon,
      $text,
      $alignmentType,
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(IconModifierInterface::class),
    );
  }

}
