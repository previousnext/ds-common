<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tags;

use Drupal\Core\Template\Attribute;
use Pinto\Slots;
use PreviousNext\Ds\Common\Utility\CommonObjectInterface;
use PreviousNext\Ds\Common\Utility\ObjectTrait;
use PreviousNext\IdsTools\Scenario\Scenarios;
use Ramsey\Collection\AbstractCollection;

/**
 * @template T of Tag|CheckboxTag|LinkTag = Tag|CheckboxTag|LinkTag
 * @extends \Ramsey\Collection\AbstractCollection<T>
 */
#[Scenarios([TagsScenarios::class])]
class Tags extends AbstractCollection implements CommonObjectInterface {
  use ObjectTrait;

  /**
   * @phpstan-param iterable<T> $tags
   */
  final private function __construct(
    iterable $tags,
    public Attribute $containerAttributes,
  ) {
    parent::__construct(\iterator_to_array($tags));
  }

  public function getType(): string {
    return 'unused.';
  }

  protected function checkType(string $type, mixed $value): bool {
    return $value instanceof Tag || $value instanceof CheckboxTag || $value instanceof LinkTag;
  }

  /**
   * @phpstan-param iterable<Tag|CheckboxTag|LinkTag> $tags
   */
  public static function create(
    iterable $tags = [],
  ): static {
    return static::factoryCreate(
      tags: $tags,
      containerAttributes: new Attribute(),
    );
  }

  protected function build(Slots\Build $build): Slots\Build {
    $tags = $this->map(static function (Tag|CheckboxTag|LinkTag $tag): mixed {
      return match (TRUE) {
        $tag instanceof Tag => $tag->title,
        $tag instanceof CheckboxTag => $tag->label,
        $tag instanceof LinkTag => $tag->title,
      };
    })->toArray();

    return $build->set('tags', $tags);
  }

}
