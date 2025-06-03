<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\Component\SearchForm;

final class SearchFormScenarios {

  final public static function searchForm(): SearchForm {
    return SearchForm::create('http://example.com/search');
  }

}
