<?php

declare(strict_types=1);

namespace PreviousNext\Ds\Common\BundleClass\Command;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use PreviousNext\Ds\Common\BundleClass\Attribute\BundleClassMetadata;
use PreviousNext\Ds\Common\BundleClass\ExpectedFields\EntityReferenceResolver;
use PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFields;
use PreviousNext\Ds\Common\BundleClass\Registry;
use Ramsey\Collection\GenericArray;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
  name: 'pnx-common:health-check',
  description: <<<'DESC'
    Health check for configuration and schema.
    DESC,
)]
final class BundleClassHealthCheck extends Command {

  protected const IDE_LAUNCH = [
    'emacs' => 'emacs://open?url=file://%s&line=%s',
    'macvim' => 'mvim://open?url=file://%s&line=%s',
    'phpstorm' => 'phpstorm://open?file=%s&line=%s',
    'sublime' => 'subl://open?url=file://%s&line=%s',
    'textmate' => 'txmt://open?url=file://%s&line=%s',
    'vscode' => 'vscode://file/%s:%s',
  ];

  private static string $ideLaunch = self::IDE_LAUNCH['phpstorm'];

  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityTypeBundleInfoInterface $entityTypeBundleInfo,
  ) {
    parent::__construct();
  }

  protected function execute(InputInterface $input, OutputInterface $output): int {
    $io = new SymfonyStyle($input, $output);

    $allBundleInfo = $this->entityTypeBundleInfo->getAllBundleInfo();
    $taskCreateBundle = [];

    /** @var array<array{class-string, \PreviousNext\Ds\Common\BundleClass\Attribute\BundleClassMetadata, class-string, bool}> $bundleClasses */
    $bundleClasses = [];
    foreach (Registry::bundleClasses() as $bundleClass => $metadata) {
      $entityTypeId = $metadata->entityTypeId;
      $bundle = $metadata->bundle;
      $bundleClassMetadata = BundleClassMetadata::reflectOn($bundleClass);

      if (!$this->entityTypeManager->hasDefinition($entityTypeId)) {
        $io->error('Expected entity type ' . $entityTypeId . ' for  ' . $bundleClass);

        continue;
      }

      $bundleInfo = $allBundleInfo[$entityTypeId][$bundle] ?? NULL;
      if ($bundleInfo !== NULL) {
        $bundleClasses[] = [$bundleClass, $metadata, $bundleClass, TRUE];
        continue;
      }

      if ($bundleClassMetadata->optional === FALSE && $bundleClassMetadata->ifNotMeThenA === NULL) {
        throw new \LogicException(\sprintf('#[BundleClassMetadata(ifNotMeThenA)] must be set if the optional=FALSE on `%s`', $bundleClass));
      }

      // Then ensure a bundle with the interface is implemented... otherwise
      // offer to create.
      $otherBundlesImplementing = \iterator_to_array(EntityReferenceResolver::resolve($bundleClassMetadata->ifNotMeThenA));
      if ([] === $otherBundlesImplementing) {
        // If no other bundles implement the bundle at `ifNotMeThenA` then offer
        // to create a bundle implementing it.
        $taskCreateBundle[] = [$bundleClassMetadata->ifNotMeThenA, $bundleClass, $entityTypeId, $bundle];
      }
      else {
        foreach ($otherBundlesImplementing as $otherBundleClassImplementing => ['entityTypeId' => $entityTypeId, 'bundle' => $bundle]) {
          $bundleClasses[] = [$otherBundleClassImplementing, new BundleClassMetadata($entityTypeId, $bundle), $bundleClass, FALSE];
        }
      }
    }

    $io->title('Bundles');
    $rows = [];
    foreach ($taskCreateBundle as [$ifNotMeThenA, , $entityTypeId, $bundle]) {
      $rows[] = [\implode(' or ', $ifNotMeThenA), $entityTypeId, $bundle, '<fg=black;bg=red> Missing </>'];
    }
    foreach ($bundleClasses as [$bundleClass, $metadata]) {
      $rows[] = [$bundleClass, $metadata->entityTypeId, $metadata->bundle, '<fg=black;bg=green> OK </>'];
    }
    $io->table(
      headers: ['Bundle', 'Entity Type', 'Bundle', 'Status'],
      rows: $rows,
    );

    if ([] !== $taskCreateBundle) {
      foreach ($taskCreateBundle as [$ifNotMeThenA, $bundleClass]) {
        // @todo createDefaultBundle to an interface.
        $config = $bundleClass::createDefaultBundle();

        $ifNotMeThenA = \array_map(
          static fn (string $ifNotMeThenAClass): string => static::linkClass($ifNotMeThenAClass),
          $ifNotMeThenA,
        );

        // This may blow up with ID conflicts. In which case quit and ask the
        // user to create one manually.
        $requiredInterfaces = \implode(' or ', $ifNotMeThenA);

        $io->title('Bundle implementing interface not found');
        $io->listing([
          \sprintf('A bundle implementing %s is required by an object bundle.', $requiredInterfaces),
          'No bundles implementing it were found.',
          \sprintf('You may choose to create a bundle implementing %s on your own, or one with the following metadata will be created:', $requiredInterfaces),
        ]);
        $io->table(
          headers: ['ID', 'Label', 'Type'],
          rows: [[$config->id(), $config->label(), $config::class]],
        );
        $shallCreate = $io
          ->confirm(
            question: \sprintf('Shall we create one for you? Otherwise you need to create a bundle implementing %s on your own before continuing.', $requiredInterfaces),
            default: FALSE,
          );

        if ($shallCreate === FALSE) {
          $io->newLine();
          $io->text('Please create a bundle class implementing ' . $requiredInterfaces);
          $io->newLine();

          return static::FAILURE;
        }

        $config->save();
      }

      // Force manual reset even if all configs were satisfied.
      $io->warning('Please re-run the command to continue with field creation.');
      return static::FAILURE;
    }

    $io->title('Bundle classes');
    $reportRows = [];
    foreach ($bundleClasses as [$bundleClass, $metadata]) {
      $entityTypeId = $metadata->entityTypeId;
      $bundle = $metadata->bundle;
      $bundleInfo = $allBundleInfo[$entityTypeId][$bundle] ?? NULL;
      $reportRow = [$entityTypeId, $bundle, static::linkClass($bundleClass)];

      $actualBundleClassName = $bundleInfo['class'];
      if ($actualBundleClassName === NULL) {
        $reportRow[] = 'Bundle class not set on bundle';
      }
      else {
        // @todo handle bundle classes extending the common one.
        if ($actualBundleClassName !== $bundleClass) {
          $reportRow[] = 'Unexpected class';
          $io->error(\sprintf('Found `%s` for bundle class, but expected `%s`', $actualBundleClassName, static::linkClass($bundleClass)));
        }
        else {
          $reportRow[] = '<fg=black;bg=green> OK </>';
        }
      }

      $reportRows[] = $reportRow;
    }

    $io->table(
      headers: ['Entity Type', 'Bundle', 'Bundle class', 'Status'],
      rows: $reportRows,
    );

    $io->title('Fields');
    foreach ($bundleClasses as [$bundleClass, $metadata, $getExpectedMetadataFrom, $createFieldsForMe]) {
      $entityTypeId = $metadata->entityTypeId;
      $bundle = $metadata->bundle;

      if (FALSE === $createFieldsForMe) {
        $io->text(\sprintf('Not creating fields for %s, it is using a custom bundle class.', static::linkClass($bundleClass)));
        continue;
      }

      /** @var \Ramsey\Collection\AbstractArray<\PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFieldInterface> $taskCreateFieldStorage */
      $taskCreateFieldStorage = new GenericArray();
      /** @var \Ramsey\Collection\AbstractArray<\PreviousNext\Ds\Common\BundleClass\ExpectedFields\ExpectedFieldInterface> $taskCreateFieldInstance */
      $taskCreateFieldInstance = new GenericArray();
      $okFieldInstances = new GenericArray();

      $expectedFields = ExpectedFields::reflectOn($getExpectedMetadataFrom);
      foreach ($expectedFields->fields as $field) {
        $fieldName = $field->getMachineName();
        if (NULL === FieldStorageConfig::loadByName($entityTypeId, $fieldName)) {
          $taskCreateFieldStorage[] = $field;
          $taskCreateFieldInstance[] = $field;

          continue;
        }

        if (NULL === FieldConfig::loadByName($entityTypeId, $bundle, $fieldName)) {
          $taskCreateFieldInstance[] = $field;

          continue;
        }

        $okFieldInstances[] = $field;
      }

      // Field storage and instances.
      $io->newLine();
      $io->text(\sprintf('Field instances for bundle `%s:%s` [`%s`]', $entityTypeId, $bundle, static::linkClass($bundleClass)));
      $io->newLine();
      $rows = [];
      foreach ($okFieldInstances as $field) {
        $rows[] = ['Storage', $field->getMachineName(), '<fg=black;bg=green> OK </>'];
        $rows[] = ['Instance', $field->getMachineName(), '<fg=black;bg=green> OK </>'];
      }
      foreach ($taskCreateFieldStorage as $field) {
        $rows[] = ['Storage', $field->getMachineName(), '<fg=black;bg=red> Missing </>'];
      }
      foreach ($taskCreateFieldInstance as $field) {
        $rows[] = ['Instance', $field->getMachineName(), '<fg=black;bg=red> Missing </>'];
      }
      if ([] === $rows) {
        $rows[] = ['', '', '<fg=black;bg=green> No fields required </>'];
      }
      $io->table(['Type', 'Field Name', 'Status'], $rows);

      if ($taskCreateFieldStorage->count() !== 0 || $taskCreateFieldInstance->count() !== 0) {
        if (FALSE === $io->confirm('Create missing fields?', default: FALSE)) {
          $io->warning('Skipped creating fields');
          continue;
        }

        $io->success('Creating fields');
        foreach ($taskCreateFieldStorage as $item) {
          $item->fieldStorage($metadata)
            ->setSettings($item->storageSettings())
            ->save();
        }

        foreach ($taskCreateFieldInstance as $item) {
          $item
            ->fieldInstance($metadata)
            ->setSettings($item->instanceSettings())
            ->save();
        }
      }
    }

    return static::SUCCESS;
  }

  private static function ideLink(string $path, int $line): string {
    return \sprintf(static::$ideLaunch, $path, (string) $line);
  }

  private static function href(string $uri, string $innerText): string {
    return "\e]8;;{$uri}\e\\{$innerText}\e]8;;\e\\";
  }

  private static function linkClass($classString): string {
    $rClass = new \ReflectionClass($classString);
    return static::href(static::ideLink(\substr($rClass->getFileName(), \strlen('/data')), $rClass->getStartLine() ?: 0), $classString);
  }

}
