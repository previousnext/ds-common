<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Pinto\Attribute\Definition;
use Pinto\List\ObjectListTrait;

/**
 * @phpstan-require-implements \Pinto\List\ObjectListInterface
 */
trait ListTrait {

  use ObjectListTrait;

  public function name(): string {
    $name = $this instanceof \BackedEnum ? $this->value : $this->name;
    // Make the hook_theme() key unique between lists.
    return \sprintf('%s-%s-%s', \substr(\md5(static::class), 0, 10), (new \ReflectionClass(static::class))->getShortName(), $name);
  }

  public function libraryName(): string {
    return $this->name();
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
    // @todo Improve this.
    return \substr(
      string: $objectClassDir,
      offset: (
        // @phpstan-ignore-next-line
        \strpos($objectClassDir, 'Atom/') ?: (
        // @phpstan-ignore-next-line
        \strpos($objectClassDir, 'Component/') ?: (
        // @phpstan-ignore-next-line
        \strpos($objectClassDir, 'Layout/') ?: throw new \LogicException(\sprintf('Couldnt resolve %s component.', $definition->className))
        ))),
    );
  }

}
