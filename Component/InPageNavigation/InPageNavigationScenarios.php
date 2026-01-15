<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\InPageNavigation;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Component as CommonComponents;
use PreviousNext\Ds\Common\Layout\Section\Section;
use PreviousNext\Ds\Common\Layout\Section\SectionType;
use PreviousNext\IdsTools\Scenario\ScenarioSubject;

final class InPageNavigationScenarios {

  final public static function inPageNavigation(): ScenarioSubject {
    $section = Section::create(
      as: SectionType::Div,
      heading: 'In page nav container',
    );

    $instance = InPageNavigation::create(
      heading: Atom\Heading\Heading::create('Example!', Atom\Heading\HeadingLevel::Two),
    );
    $instance->containerAttributes['hello'] = 'world';
    $instance->containerAttributes['class'][] = 'foo';
    $instance->modifiers[] = IncludeHeadingLevels::H1;
    $instance->modifiers[] = IncludeHeadingLevels::H2;
    $instance->modifiers[] = IncludeHeadingLevels::H3;

    $section[] = $instance;

    $content = Section::create(
      as: SectionType::Div,
      isContainer: FALSE,
    );
    $content->containerAttributes['class'][] = 'js-content';

    $m = 0;
    for ($n = 1; $n <= 3; $n++) {
      foreach (CommonComponents\InPageNavigation\IncludeHeadingLevels::cases() as $heading) {
        $m++;
        $content[] = Atom\Html\Html::create(Markup::create(\sprintf('<%s id="heading-no%d">Test Heading (%s) #%d/%d</%s>', $heading->selector(), $m, $heading->selector(), $n, $m, $heading->selector())));
        $content[] = Atom\Html\Html::create(Markup::create('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi.</p>'));
      }
    }

    $section[] = $content;
    return ScenarioSubject::createFromWiderContext($instance, $section);
  }

}
