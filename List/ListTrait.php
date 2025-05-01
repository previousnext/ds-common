<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\List;

use Pinto\Attribute\Definition;
use Pinto\List\ObjectListTrait;
use PreviousNext\Ds\Common\Component;

/**
 * @phpstan-require-implements \Pinto\List\ObjectListInterface
 */
trait ListTrait {

  use ObjectListTrait;

  public function name(): string
  {
    $name = $this instanceof \BackedEnum ? $this->value : $this->name;
    // Make the hook_theme() key unique between lists.
    return sprintf('%s-%s', \substr(md5(static::class), 0, 10), $name);
  }

  public function libraryName(): string {
    return $this->name();
  }

  public function templateName(): string {
    // Single directory, just name them template instead of the enum value.
    return 'template';
  }

  /**
   * {@inheritdoc}
   */
  public function cssDirectory(): string {
    // @todo fix Pinto to allow DRUPAL_ROOT relative paths like you could in
    // 0.1.6.
    return '/data/app/libraries/ids';
  }

  /**
   * {@inheritdoc}
   */
  public function jsDirectory(): string {
    // @todo fix Pinto to allow DRUPAL_ROOT relative paths like you could in
    // 0.1.6.
    return '/data/app/libraries/ids';
  }

  /**
   * Resolve the subdirectory in this library
   *
   * Without slashes before and after.
   */
  private function resolveSubDirectory(): string {
    $definition = ((new \ReflectionEnumUnitCase($this::class, $this->name))->getAttributes(Definition::class)[0] ?? NULL)?->newInstance() ?? throw new \LogicException('All component cases must have a `' . Definition::class . '`.');

    /** @var string $fileName */
    $fileName = (new \ReflectionClass($definition->className))->getFileName();
    $objectClassDir = \dirname($fileName);
    return substr(
      string: $objectClassDir,
      offset: (
        strpos($objectClassDir, 'Component/') ?: (
        strpos($objectClassDir, 'Layout/') ?: throw new \LogicException(\sprintf('Couldnt resolve %s component.', $definition->className))
      )),
    );
  }

}
