<?php

// @phpcs:disable Drupal.NamingConventions.ValidEnumCase.StartWithCapital


declare(strict_types=1);

namespace PreviousNext\Ds\Common\Layout\Header;

enum HeaderSlots {

  case logo;
  case title;
  case description;
  case search;
  case navigation;
  case controls;

}
