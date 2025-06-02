<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\InPageAlert;

use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use PreviousNext\Ds\Common\Atom as CommonAtoms;

final class InPageAlertScenarios {

  public static function inPageAlert(): InPageAlert {
    $url = \Mockery::mock(Url::class);
    $url->expects('toString')->andReturn('http://example.com/');

    /** @var InPageAlert $instance */
    $instance = InPageAlert::create(
      CommonAtoms\Heading\Heading::create('Heading!'),
      Type::Success,
      CommonAtoms\Html\Html::create(Markup::create('<div>Foo <strong>bar</strong></div>')),
      CommonAtoms\Link\Link::create(title: '', url: $url),
    );
    return $instance;
  }

}
