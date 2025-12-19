<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Drupal\pinto\Resource\DrupalLibraryInterface;
use Pinto\Attribute\Definition;
use Pinto\Attribute\ObjectType;
use Pinto\List\ObjectListInterface;
use PreviousNext\Ds\Common\Layout;
use PreviousNext\Ds\Common\Utility\Twig;

#[ObjectType\Slots(method: 'create', bindPromotedProperties: TRUE)]
enum CommonLayouts implements ObjectListInterface, DrupalLibraryInterface {

  use ListTrait;

  #[Definition(Layout\Footer\Footer::class)]
  case Footer;

  #[Definition(Layout\Grid\Grid::class)]
  case Grid;

  #[Definition(Layout\Grid\GridItem\GridItem::class)]
  case GridItem;

  #[Definition(Layout\Header\Header::class)]
  case Header;

  #[Definition(Layout\Masthead\Masthead::class)]
  case Masthead;

  #[Definition(Layout\Section\Section::class)]
  case Section;

  #[Definition(Layout\Sidebar\Sidebar::class)]
  case Sidebar;

  public function templateDirectory(): string {
    return \sprintf('@%s/%s', Twig::NAMESPACE, $this->resolveSubDirectory());
  }

}
