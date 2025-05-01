# LinkList Component

## Sample usage

`LinkList` can be treated as a collection:

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$linkList = CommonComponents\LinkList\LinkList::create();
$linkList[] = \PreviousNext\Ds\Common\Atom\Link\Link::create();

$build = $linkList();
```
