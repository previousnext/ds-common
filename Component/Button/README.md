# Button Component

## Sample usage

### Link

```php
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;

$build['ButtonLink'] = CommonComponents\Button\Button::create(
  title: 'Link button',
  as: CommonComponents\Button\ButtonType::Link,
  href: Atom\Link\Link::fromUrl(Url::fromRoute('<front>')),
)();
```

### Button

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$build['ButtonButton'] = CommonComponents\Button\Button::create(
  title: 'Button button',
  as: CommonComponents\Button\ButtonType::Button,
)();
```
