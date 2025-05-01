<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\TaxonomyTerm;

use Drupal\Core\Config\Entity\ConfigEntityInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;
use PreviousNext\Ds\Common\BundleClass\Attribute;
use PreviousNext\Ds\Common\BundleClass\ExpectedFields;

/**
 * Default implementation of a tag term.
 */
#[Attribute\BundleClassMetadata('taxonomy_term', 'tags', optional: TRUE, ifNotMeThenA: [TermTagInterface::class])]
#[ExpectedFields\ExpectedFields(fields: [])]
class TermTag extends Term implements TermTagInterface {

  final public static function createDefaultBundle(): ConfigEntityInterface {
    return Vocabulary::create([
      'name' => 'Tags',
      'description' => 'Created by PNX Common.',
      'vid' => 'tags',
    ]);
  }

}
