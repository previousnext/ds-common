<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Pinto\Attribute\Definition;
use Pinto\Attribute\ObjectType;
use Pinto\List\ObjectListInterface;
use PreviousNext\Ds\Common\Component;
use PreviousNext\Ds\Common\Utility\Twig;

#[ObjectType\Slots(method: 'create', bindPromotedProperties: TRUE)]
enum CommonComponents implements ObjectListInterface {

  use ListTrait;

  #[Definition(Component\Accordion\Accordion::class)]
  case Accordion;

  #[Definition(Component\Accordion\AccordionItem\AccordionItem::class)]
  case AccordionItem;

  #[Definition(Component\Button\Button::class)]
  case Button;

  #[Definition(Component\Callout\Callout::class)]
  case Callout;

  #[Definition(Component\Card\Card::class)]
  case Card;

  #[Definition(Component\Media\ExternalVideo\ExternalVideo::class)]
  case ExternalVideo;

  #[Definition(Component\HeroBanner\HeroBanner::class)]
  case HeroBanner;

  #[Definition(Component\Media\Image\Image::class)]
  case Image;

  #[Definition(Component\InPageAlert\InPageAlert::class)]
  case InPageAlert;

  #[Definition(Component\LinkList\LinkList::class)]
  case LinkList;

  #[Definition(Component\Media\Media::class)]
  case Media;

  public function templateDirectory(): string {
    return \sprintf('@%s/%s', Twig::NAMESPACE, $this->resolveSubDirectory());
  }

}
