# Accordion Component

## Sample usage

A method is provided to allow quick additions.

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$build = (CommonComponents\Accordion\Accordion::create(title: 'Hello World!')
  ->addSimple('Title', 'Body')
)();
```

`Accordion` can be treated as a collection:

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$accordion = CommonComponents\Accordion\Accordion::create(title: 'Hello World!');
$accordion[] = PreviousNext\Ds\Common\Component\Accordion\AccordionItem\AccordionItem::create('Title', 'Body');

$build = $accordion();
```
