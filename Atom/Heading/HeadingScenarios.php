<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Atom\Heading;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom\Html\Html;

final class HeadingScenarios {

  final public static function headingStandard(): Heading {
    $heading = Heading::create(
      heading: 'Heading text',
      level: HeadingLevel::Two,
    );
    $heading->containerAttributes['id'] = 'my-heading';
    $heading->containerAttributes['class'][] = 'a-class';
    return $heading;
  }

  final public static function headingText(): Heading {
    return Heading::create(
      heading: 'Heading text',
      level: HeadingLevel::Two,
    );
  }

  final public static function headingHtml(): Heading {
    return Heading::create(
      heading: Html::create(Markup::create('Hello <em>world!</em>')),
      level: HeadingLevel::Two,
    );
  }

  final public static function headingLevel(): \Generator {
    foreach (HeadingLevel::cases() as $level) {
      yield \sprintf('level-%s', $level->name) => Heading::create(
        heading: 'Heading text',
        level: $level,
      );
    }
  }

  /**
   * No visual differences expected, only snapshot (markup).
   */
  final public static function headingIsExcluded(): Heading {
    $heading = Heading::create(
      heading: 'Heading!',
      level: HeadingLevel::Two,
    );
    $heading->isExcluded = TRUE;
    return $heading;
  }

}
