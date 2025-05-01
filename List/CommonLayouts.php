<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Drupal\pinto\List\StreamWrapperAssetInterface;
use Pinto\Attribute\Asset;
use Pinto\Attribute\Definition;
use Pinto\Attribute\ObjectType;
use Pinto\List\ObjectListInterface;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Layout;
use PreviousNext\Ds\Common\Utility\Twig;

#[Asset\Css('styles.css', preprocess: true)]
#[ObjectType\Slots(bindPromotedProperties: TRUE, method: 'create')]
enum CommonLayouts implements ObjectListInterface, StreamWrapperAssetInterface {

  use ListTrait;

  #[Definition(Layout\Grid\Grid::class)]
  case Grid;

  #[Definition(Layout\Grid\GridItem\GridItem::class)]
  case GridItem;

  #[Definition(Layout\Section\Section::class)]
  case Section;

  public function templateDirectory(): string {
    return sprintf('@%s/%s', Twig::Namespace, $this->resolveSubDirectory());
  }

}
