<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\ExpectedFields;

#[\Attribute(flags: \Attribute::TARGET_CLASS)]
final class ExpectedFields {

  /**
   * @phpstan-param \PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFieldInterface[] $fields
   */
  public function __construct(
    public array $fields,
  ) {
  }

  /**
   * @phpstan-param class-string $className
   */
  final public static function reflectOn($className): static {
    $r = new \ReflectionClass($className);
    $attr = $r->getAttributes(static::class)[0] ?? throw new \LogicException('Missing ' . static::class . ' attribute on ' . $className);
    return $attr->newInstance();
  }

}
