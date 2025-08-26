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

  #[Definition(Component\Breadcrumb\Breadcrumb::class)]
  case Breadcrumb;

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

  #[Definition(Component\InPageNavigation\InPageNavigation::class)]
  case InPageNavigation;

  #[Definition(Component\LinkList\LinkList::class)]
  case LinkList;

  #[Definition(Component\ListItem\ListItem::class)]
  case ListItem;

  #[Definition(Component\Media\Media::class)]
  case Media;

  #[Definition(Component\Navigation\Navigation::class)]
  case Navigation;

  #[Definition(Component\Pagination\Pagination::class)]
  case Pagination;

  #[Definition(Component\Pagination\PaginationItem\PaginationItem::class)]
  case PaginationItem;

  #[Definition(Component\SearchForm\SearchForm::class)]
  case SearchForm;

  #[Definition(Component\SideNavigation\SideNavigation::class)]
  case SideNavigation;

  #[Definition(Component\SocialLinks\SocialLinks::class)]
  case SocialLinks;

  #[Definition(Component\Steps\Steps::class)]
  case Steps;

  #[Definition(Component\Steps\Step\Step::class)]
  case Step;

  #[Definition(Component\Tabs\Tabs::class)]
  case Tabs;

  #[Definition(Component\Tabs\TabItem\TabItem::class)]
  case TabItem;

  #[Definition(Component\Tabs\TabListItem\TabListItem::class)]
  case TabListItem;

  #[Definition(Component\Tags\Tags::class)]
  case Tags;

  public function templateDirectory(): string {
    return \sprintf('@%s/%s', Twig::NAMESPACE, $this->resolveSubDirectory());
  }

}
