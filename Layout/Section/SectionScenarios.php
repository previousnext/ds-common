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
      link: Atom\Link\Link::create(title: 'A link for section!', url: $url),
      background: Component\Media\Image\Image::createSample(256, 256),
    );
    $instance[] = Atom\Html\Html::create(Markup::create('<div>Section <strong>contents</strong> 1</div>'));
    $instance[] = Atom\Html\Html::create(Markup::create('<div>Section <strong>contents</strong> 2</div>'));
    $instance->containerAttributes['foo'] = 'bar';
    $instance->containerAttributes['class'][] = 'hello';
    $instance->containerAttributes['class'][] = 'world';
    return $instance;
  }

  final public static function sectionObjectContent(): Section {
    /** @var Section $instance */
    $instance = Section::create(
      as: SectionType::Div,
      heading: 'Section title',
    );
    $instance[] = Component\Card\Card::create(NULL, NULL, heading: Atom\Heading\Heading::create('Card!', Atom\Heading\HeadingLevel::Two));
    return $instance;
  }

  final public static function sectionIsContainer(): \Generator {
    foreach ([TRUE, FALSE] as $isContainer) {
      $instance = Section::create(
        heading: 'Section title',
        as: SectionType::Section,
        isContainer: $isContainer,
      );
      $instance[] = Atom\Html\Html::create(Markup::create('<div>Section <strong>contents</strong></div>'));
      yield ($isContainer ? 'is-container' : 'not-container') => $instance;
    }
  }

}
