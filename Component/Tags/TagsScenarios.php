<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\Tags;

final class TagsScenarios {

  final public static function tags(): Tags {
    $tags = Tags::create();
    $tags[] = Tag::create('Tag 1');
    $tags[] = Tag::create('Tag 2');
    $tags[] = Tag::create('Tag 3');
    return $tags;
  }

}
