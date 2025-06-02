<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Callout;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;

#[Scenarios([CalloutScenarios::class])]
class Callout implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  final private function __construct(
    public Atom\Heading\Heading $heading,
    public Atom\Html\Html $content,
    public Attribute $containerAttributes,
  ) {
  }

  public static function create(
    Atom\Heading\Heading $heading,
    Atom\Html\Html $content,
  ): static {
    return static::factoryCreate(
      $heading,
      $content,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('heading', $this->heading->heading)
      ->set('content', $this->content->markup);
  }

}
