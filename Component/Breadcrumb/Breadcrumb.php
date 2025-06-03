<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Breadcrumb;

use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @extends \Ramsey\Collection\AbstractCollection<\PreviousNext\Ds\Common\Atom\Link\Link>
 */
#[ObjectType\Slots(slots: [
  'links',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([BreadcrumbScenarios::class])]
class Breadcrumb extends AbstractCollection implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  private function __construct(
    public Attribute $containerAttributes,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Atom\\Link\\Link';
  }

  public static function create(): static {
    return static::factoryCreate(
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    return $build
      ->set('links', $this->map(static fn (Atom\Link\Link $item): mixed => $item())->toArray());
  }

}
