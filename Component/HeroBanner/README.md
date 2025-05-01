# HeroBanner Component

## Sample usage

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$heroBannerImage = CommonComponents\HeroBanner\HeroBanner::create(
  'Title!',
  'Subtitle!',
  link: Atom\Link\LinkWithLabel::fromLabelAndUrl('Hero Banner Link!', Url::fromRoute('<front>')),
  image: CommonComponents\Media\Image\Image::createSample(600, 200),
);
$build['HeroBannerImage'] = $heroBannerImage();

$heroBannerImageLinkList = CommonComponents\HeroBanner\HeroBanner::create(
  'Hero Link List Title!',
  'Hero Link List Subtitle!',
  links: CommonComponents\LinkList\LinkList::create([
    Link::fromUrl(Url::fromRoute('<front>')),
  ]),
);
$build['HeroBannerLinkList'] = $heroBannerImageLinkList();
```
