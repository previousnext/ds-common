# InPageAlert Component

## Sample usage

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$build['InPageAlert'] = CommonComponents\InPageAlert\InPageAlert::create(
  Heading::create('Heading!'),
  CommonComponents\InPageAlert\Type::Success,
  Html::create(Markup::create('<div>Foo <strong>bar</strong></div>')),
  Link::fromUrl(Url::fromRoute('<front>')),
)();
```
