# Button Component

## Sample usage

### Link

```php
use PreviousNext\Ds\Common\Atom;

$build['ButtonLink'] = Atom\Button\Button::create(
  title: 'Link button',
  as: Atom\Button\ButtonType::Link,
  href: Atom\Link\Link::fromUrl(Url::fromRoute('<front>')),
)();
```

### Button

```php
use PreviousNext\Ds\Common\Atom;

$build['ButtonButton'] = Atom\Button\Button::create(
  title: 'Button button',
  as: Atom\Button\ButtonType::Button,
)();
```
