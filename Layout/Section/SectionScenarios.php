<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Section;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component;

final class SectionScenarios {

  final public static function section(): Section {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Section $instance */
    $instance = Section::create(
      heading: 'Section title',
      as: SectionType::Div,
      content: Atom\Html\Html::create(Markup::create('<div>Section <strong>contents</strong></div>')),
      link: Atom\Link\Link::create(title: 'A link for section!', url: $url),
      background: Component\Media\Image\Image::createSample(256, 256),
    );
    $instance->containerAttributes['foo'] = 'bar';
    $instance->containerAttributes['class'][] = 'hello';
    $instance->containerAttributes['class'][] = 'world';
    return $instance;
  }

}
