# Section Component

## Sample usage

```php
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Layout as CommonLayouts;

$section = CommonLayouts\Section\Section::create(
  as: CommonLayouts\Section\SectionType::Div,
  content: Atom\Html\Html::create(Markup::create('<div>Section <strong>contents</strong></div>')),
);
$section->containerAttributes['foo'] = 'bar';
$section->containerAttributes['class'][] = 'hello';
$section->containerAttributes['class'][] = 'world';

$build['Section'] = $section();
```
