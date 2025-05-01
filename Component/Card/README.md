# Card Component

## Sample usage

### Minimal

```php
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;

$build['Card'] = CommonComponents\Card\Card::create(
  image: CommonComponents\Media\Image\Image::createSample(300, 400),
  links: CommonComponents\LinkList\LinkList::create([
    Link::fromUrl(Url::fromRoute('<front>')),
  ]),
  date: new \DateTimeImmutable('1st January 2001'),
  icon: Atom\Icon\Icon::create(icon: 'Foo'),
  tags: new Atom\Tag\Tags(),
)();
```
