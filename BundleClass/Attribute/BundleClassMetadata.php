<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\Attribute;

#[\Attribute(flags: \Attribute::TARGET_CLASS)]
final class BundleClassMetadata {

  public string $bundle;

  /**
   * @param array<class-string<\Drupal\Core\Entity\EntityInterface>>|null $ifNotMeThenA
   */
  public function __construct(
    public string $entityTypeId,
    string $bundle,
    public bool $optional = FALSE,
    public ?array $ifNotMeThenA = NULL,
  ) {
    $this->bundle = $bundle ?? $this->entityTypeId;
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
