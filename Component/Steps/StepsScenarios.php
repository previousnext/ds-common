<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Steps;

use Drupal\Core\Render\Markup;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Mixtape\Component\Steps\StepsBackground;
use PreviousNext\IdsTools\Scenario\Scenario;

final class StepsScenarios {

  #[Scenario(viewPortWidth: 800, viewPortHeight: 600)]
  public static function standard(): Steps {
    /** @var Steps $instance */
    $instance = Steps::create();
    $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 1 contents')));
    $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 2 contents')));
    $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 3 contents')));
    $instance->addSimple(Markup::create('Step 4 contents'));
    $instance->addSimple(Markup::create('Step 5 contents'));
    $instance->containerAttributes['foo'] = 'bar';
    $instance->setActiveRange($instance[0], $instance[1]);
    if ($instance instanceof \PreviousNext\Ds\Mixtape\Component\Steps\Steps) {
      $instance->modifiers[] = StepsBackground::Dark;
    }
    return $instance;
  }

  /**
   * @phpstan-return \Generator<Steps>
   */
  #[Scenario(viewPortWidth: 800, viewPortHeight: 600)]
  public static function textCounters(): \Generator {
    foreach ([TRUE, FALSE] as $hasTextCounters) {
      /** @var Steps $instance */
      $instance = Steps::create();
      $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 1 contents')));
      $instance[] = $step2 = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 2 contents')));
      $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 3 contents')));
      $instance[] = $step4 = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 4 contents')));
      $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 5 contents')));
      $instance->setActiveRange(to: $step4, from: $step2);
      $instance->hasTextCounters = $hasTextCounters;
      yield ($hasTextCounters ? 'with text counters' : 'without text counters') => $instance;
    }
  }

  /**
   * @phpstan-return \Generator<Steps>
   */
  #[Scenario(viewPortWidth: 800, viewPortHeight: 600)]
  public static function hasBackgroundFill(): \Generator {
    foreach ([TRUE, FALSE] as $hasBackgroundFill) {
      /** @var Steps $instance */
      $instance = Steps::create();
      $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 1 contents')));
      $instance[] = $step2 = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 2 contents')));
      $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 3 contents')));
      $instance[] = $step4 = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 4 contents')));
      $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create('Step 5 contents')));
      $instance->setActiveRange(to: $step4, from: $step2);
      $instance->hasBackgroundFill = $hasBackgroundFill;
      yield ($hasBackgroundFill ? 'with background fill' : 'without background fill') => $instance;
    }
  }

  /**
   * @phpstan-return \Generator<Steps>
   */
  #[Scenario(viewPortWidth: 800, viewPortHeight: 600)]
  public static function stepRanges(): \Generator {
    /** @var array<array{0: int|StepRange, 1?: int|StepRange}> $cases */
    $cases = [
      'typical, to after from (2-4)' => [4, 2],
      'to step before from (2-4)' => [2, 4],
      'one step (4)' => [4, 4],
      'to step, default from (1-4)' => [4],
      'to end, default start (1-5)' => [StepRange::End],
      'to start, default end (1)' => [StepRange::Start],
      'to step, from start (1-4)' => [4, StepRange::Start],
      'to step, from end (2-5)' => [2, StepRange::End],
      'to start, from end (1-5)' => [StepRange::Start, StepRange::End],
      'typical, to end, from start (1-5)' => [StepRange::End, StepRange::Start],
      'to start from step (1-4)' => [StepRange::Start, 4],
      'to end from step (2-5)' => [StepRange::End, 2],
    ];

    foreach ($cases as $name => $case) {
      // Same container and steps for all cases.
      $instance = Steps::create();
      foreach (\range(1, 5) as $n) {
        $instance[] = Step\Step::create(Atom\Html\Html::create(Markup::create(\sprintf('Step %s contents', $n))));
      }

      $range = [
        // "To" is always present.
        'to' => $case[0],
      ];

      if (\is_int($range['to'])) {
        // When the item is an int, get the nth item from the steps object.
        $range['to'] = $instance[$range['to'] - 1];
      }

      // "From" is optional.
      if (isset($case[1])) {
        $range['from'] = $case[1];
        if (\is_int($range['from'])) {
          // When the item is an int, get the nth item from the steps object.
          $range['from'] = $instance[$range['from'] - 1];
        }
      }

      yield \str_replace(['(', ')'], '', $name) => $instance->resetRange()->setActiveRange(...$range);
    }
  }

  final public static function contentCollection(): Steps {
    $instance = Steps::create();
    $instance[] = $step = Step\Step::create(Atom\Html\Html::create(Markup::create('Item 0.')));
    $step[] = Atom\Html\Html::create(Markup::create(<<<MARKUP
        <p>Item 1.</p>
        MARKUP));
    $step[] = Atom\Button\Button::create(title: 'Item 2', as: Atom\Button\ButtonType::Link);
    return $instance;
  }

}
