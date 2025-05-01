# Callout Component

## Sample usage

```php
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;

$callout = CommonComponents\Callout\Callout::create(
  Atom\Heading\Heading::create('Heading!'),
  Atom\Html\Html::create(Markup::create('<div>Foo <strong>bar</strong></div>')),
);

$callout->containerAttributes['foo'] = 'bar';
$callout->containerAttributes['class'][] = 'hello';
$callout->containerAttributes['class'][] = 'world';

$build['Callout'] = $callout();
```
