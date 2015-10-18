<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\HelperSet;

/* @var HelperSet $helperSet */
$helperSet = require __DIR__.'/cli-config.php';

$application = new Application();

$application->setHelperSet($helperSet);

$application->addCommands([
    // Doctrine ORM
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\CollectionRegionCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\EntityRegionCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\QueryRegionCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
    new \Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
    new \Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new \Doctrine\ORM\Tools\Console\Command\InfoCommand(),
    new \Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand(),
    new \Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
    new \Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),

    // Doctrine DBAL
    new \Doctrine\DBAL\Tools\Console\Command\ImportCommand(),
    new \Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand(),
    new \Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),

    // PHP-CS-Fixer
    new \Symfony\CS\Console\Command\FixCommand(),
    new \Symfony\CS\Console\Command\ReadmeCommand(),
    new \Symfony\CS\Console\Command\SelfUpdateCommand(),

    // Doctrine Migrations
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new \Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand(),
]);
$application->run();
