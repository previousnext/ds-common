<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Pinto\Attribute\Definition;
use Pinto\List\ObjectListTrait;

/**
 * @phpstan-require-implements \Pinto\List\ObjectListInterface
 * @phpstan-require-implements \Drupal\pinto\Resource\DrupalLibraryInterface
 */
trait ListTrait {

  use ObjectListTrait;

  public function name(): string {
    $name = $this instanceof \BackedEnum ? $this->value : $this->name;
    // Make the hook_theme() key unique between lists.
    // Should be able to remove this now that rendering is via render elements.
    return \sprintf('%s-%s-%s', \substr(\md5(static::class), 0, 10), (new \ReflectionClass(static::class))->getShortName(), $name);
  }

  public function templateName(): string {
    // Single directory, just name them template instead of the enum value.
    return 'template';
  }

  public function cssDirectory(): string {
    return \Safe\realpath(\DRUPAL_ROOT) . '/libraries/ids';
  }

  public function jsDirectory(): string {
    return \Safe\realpath(\DRUPAL_ROOT) . '/libraries/ids';
  }

  /**
   * Resolve the subdirectory in this library.
   *
   * Without slashes before and after.
   */
  private function resolveSubDirectory(): string {
    $definition = ((new \ReflectionEnumUnitCase($this::class, $this->name))->getAttributes(Definition::class)[0] ?? NULL)?->newInstance() ?? throw new \LogicException('All component cases must have a `' . Definition::class . '`.');

    /** @var string $fileName */
    $fileName = (new \ReflectionClass($definition->className))->getFileName();
    $objectClassDir = \dirname($fileName);
    // Determine the directory path part after matching against a namespace/dir.
    $offset = match (TRUE) {
      ($n = \strpos($objectClassDir, 'Atom/')) !== FALSE => $n,
      ($n = \strpos($objectClassDir, 'Component/')) !== FALSE => $n,
      ($n = \strpos($objectClassDir, 'Layout/')) !== FALSE => $n,
      ($n = \strpos($objectClassDir, 'Etc/')) !== FALSE => $n,
      default => throw new \LogicException(\sprintf('Couldnt resolve %s component.', $definition->className)),
    };
    return \substr(
      string: $objectClassDir,
      offset: $offset,
    );
  }

  public function libraryName(): string {
    // Add stability to build snapshots.
    return $this->name();
  }

  /**
   * @phpstan-return list<string>
   */
  public function attachLibraries(): array {
    // Add stability to build snapshots.
    return [
      \sprintf('pinto/%s', $this->libraryName()),
    ];
  }

}
