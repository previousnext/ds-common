<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Pinto\Attribute\Definition;
use Pinto\Attribute\ObjectType;
use Pinto\List\ObjectListInterface;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Utility\Twig;

#[ObjectType\Slots(method: 'create', bindPromotedProperties: TRUE)]
enum CommonAtoms implements ObjectListInterface {

  use ListTrait;

  #[Definition(Atom\Heading\Heading::class)]
  case Heading;

  #[Definition(Atom\Html\Html::class)]
  case Html;

  #[Definition(Atom\Icon\Icon::class)]
  case Icon;

  #[Definition(Atom\Link\Link::class)]
  case Link;

  #[Definition(Atom\Tag\Tag::class)]
  case Tag;

  public function templateDirectory(): string {
    return \sprintf('@%s/%s', Twig::NAMESPACE, $this->resolveSubDirectory());
  }

}
