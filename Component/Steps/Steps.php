<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Steps;

use Drupal\Component\Render\MarkupInterface;
use Drupal\Core\Template\Attribute;
use Pinto\Attribute\ObjectType;
use Pinto\Slots;
use PreviousNext\Ds\Common\Atom;
use PreviousNext\Ds\Common\Modifier;
use PreviousNext\Ds\Common\Utility;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractSet;

/**
 * @extends \Ramsey\Collection\AbstractSet<\PreviousNext\Ds\Common\Component\Steps\Step\Step>
 */
#[ObjectType\Slots(slots: [
  'hasBackgroundFill',
  'hasTextCounters',
  'items',
  'modifiers',
  new Slots\Slot('containerAttributes', fillValueFromThemeObjectClassPropertyWhenEmpty: 'containerAttributes'),
])]
#[Scenarios([StepsScenarios::class])]
class Steps extends AbstractSet implements Utility\CommonObjectInterface {

  use Utility\ObjectTrait;

  /**
   * @phpstan-param \WeakReference<Step\Step>|StepRange|null $to
   * @phpstan-param \WeakReference<Step\Step>|StepRange|null $from
   * @phpstan-param \PreviousNext\Ds\Common\Modifier\ModifierBag<StepsModifierInterface> $modifiers
   */
  private function __construct(
    public bool $hasBackgroundFill,
    public bool $hasTextCounters,
    public Attribute $containerAttributes,
    protected \WeakReference|StepRange|null $to,
    protected \WeakReference|StepRange|null $from,
    public Modifier\ModifierBag $modifiers,
  ) {
    parent::__construct();
  }

  public function getType(): string {
    return '\\PreviousNext\\Ds\\Common\\Component\\Steps\\Step\\Step';
  }

  public static function create(): static {
    return static::factoryCreate(
      FALSE,
      FALSE,
      containerAttributes: new Attribute(),
      modifiers: new Modifier\ModifierBag(StepsModifierInterface::class),
      to: NULL,
      from: NULL,
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    $this->applyActive();

    return $build
      ->set('hasBackgroundFill', $this->hasBackgroundFill)
      ->set('hasTextCounters', $this->hasTextCounters)
      ->set('items', $this->map(static fn (Step\Step $item): mixed => $item())->toArray());
  }

  /**
   * Set the range to a specific step already added to this collection, or set to a position at build time.
   *
   * If a step is removed from this collection, and it was assigned a position, an exception will be thrown at build.
   *
   * _From/to_ do not have a specific order: _from_ can be after _to_.
   *
   * @phpstan-return $this
   */
  public function setActiveRange(Step\Step|StepRange $to, Step\Step|StepRange $from = StepRange::Start): static {
    if ($to instanceof StepRange) {
      $this->to = $to;
    }
    else {
      if (FALSE === $this->contains($to)) {
        throw new \InvalidArgumentException('Cant set `to` active step when it does not exist in this steps collection.');
      }
      $this->to = \WeakReference::create($to);
    }

    if ($from instanceof StepRange) {
      $this->from = $from;
    }
    else {
      if (FALSE === $this->contains($from)) {
        throw new \InvalidArgumentException('Cant set `from` active step when it does not exist in this steps collection.');
      }

      $this->from = \WeakReference::create($from);
    }

    return $this;
  }

  /**
   * Sets active state on steps.
   *
   * If possible, use setActiveRange instead to dynamically compute start or end at build time.
   *
   * @phpstan-return $this
   */
  public function setActive(Step\Step ...$steps): static {
    foreach ($steps as $step) {
      $step->isEnabled = TRUE;
    }

    return $this;
  }

  /**
   * Called to apply active range.
   *
   * Applied automatically by render, used rarely when state of steps needs to be checked early.
   *
   * @phpstan-return $this
   */
  public function applyActive(): static {
    $from = $this->from instanceof \WeakReference ? $this->from->get() : $this->from;
    $to = $this->to instanceof \WeakReference ? $this->to->get() : $this->to;

    if ($to === NULL && $from === NULL) {
      // Don't do anything when there isn't a range on *both* sides. However, we do allow *either* sides to be NULL.
      return $this;
    }

    if ($from !== NULL && $from instanceof Step\Step && FALSE === $this->contains($from)) {
      throw new \InvalidArgumentException('The `from` active step does not exist in this steps collection.');
    }
    if ($to !== NULL && $to instanceof Step\Step && FALSE === $this->contains($to)) {
      throw new \InvalidArgumentException('The `to` active step does not exist in this steps collection.');
    }

    $resolveStepItem = function (Step\Step|StepRange $item): Step\Step {
      return match ($item) {
        StepRange::Start => $this->first(),
        StepRange::End => $this->last(),
        default => $item,
      };
    };

    $from ??= StepRange::Start;
    $to ??= StepRange::End;
    $from = $resolveStepItem($from);
    $to = $resolveStepItem($to);

    // The range is iterated in sequence, so check if end is before start and reverse if needed.
    $pos1 = \array_search($from, $this->data, TRUE);
    $pos2 = \array_search($to, $this->data, TRUE);
    [$from, $to] = ($pos2 < $pos1) ? [$to, $from] : [$from, $to];

    $isActive = FALSE;
    foreach ($this->data as $step) {
      if (($step === $from && $from === $to) || ($step === $from)) {
        // If they're all the same then active.
        $isActive = TRUE;
      }

      $step->isEnabled = $isActive;

      if ($step === $to) {
        // To is inclusive, so do after the step was found.
        // Don't break here, because we want to reset the state for ALL items.
        $isActive = FALSE;
      }
    }

    return $this;
  }

  /**
   * @phpstan-return $this
   */
  public function resetRange(): static {
    $this->from = NULL;
    $this->to = NULL;

    return $this;
  }

  /**
   * @phpstan-return $this
   */
  public function addSimple(
    MarkupInterface $content,
  ) {
    $this[] = Step\Step::create(
      Atom\Html\Html::create($content),
    );
    return $this;
  }

}
