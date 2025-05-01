# Media Component

## Sample usage

### Image

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$build['MediaImage'] = CommonComponents\Media\Media::create(
  media: CommonComponents\Media\Image\Image::createSample(256, 256),
  caption: 'An image.',
  alignment: CommonComponents\Media\MediaAlignmentType::Center,
)();
```

### ExternalVideo

```php
use PreviousNext\Ds\Common\Component as CommonComponents;

$build['MediaExternalVideo'] = CommonComponents\Media\Media::create(
  media: CommonComponents\Media\ExternalVideo\ExternalVideo::createSample(),
  caption: 'A video.',
  alignment: CommonComponents\Media\MediaAlignmentType::Center,
)();
```
