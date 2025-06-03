<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Masthead;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;
use PreviousNext\Ds\Common\Atom\Link\Link;

final class MastheadScenarios {

  final public static function masthead(): Masthead {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var Masthead $instance */
    $instance = Masthead::create(
      content:  CommonAtoms\Html\Html::create(Markup::create(<<<MARKUP
        Welcome to the <strong>Jungle</strong> 🎸
        MARKUP)),
    );
    $instance->links[] = Link::create('Link 1', $url);
    $instance->links[] = Link::create('Link 2', $url);
    $instance->links[] = Link::create('Link 3', $url);
    $instance->containerAttributes['hello'] = 'world';
    $instance->containerAttributes['class'][] = 'foo';
    // @todo add common modifiers?
    //   $instance->modifiers[] = MastheadBackground::Light;
    return $instance;
  }

}
