#!/usr/bin/php
<?php

use Demo\SymfonyContainer\Command\AbstractCommand;
use Demo\SymfonyContainer\Command\SimulateContactsGetCommand;
use Demo\SymfonyContainer\Command\SimulateContactsUpdateCommand;
use Demo\SymfonyContainer\Command\SimulatePaymentsGetCommand;
use Demo\SymfonyContainer\Command\SimulatePaymentsUpdateCommand;
use Demo\SymfonyContainer\Compiler\ApiManagerCompilerPass;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;

include __DIR__ . '/vendor/autoload.php';


// Bootstrap container

$containerBuilder = new ContainerBuilder();
$fileLocator = new \Symfony\Component\Config\FileLocator(__DIR__ . '/config');
$loader = new \Symfony\Component\DependencyInjection\Loader\YamlFileLoader($containerBuilder, $fileLocator);
$loader->load("config.yml");
$containerBuilder->addCompilerPass(new ApiManagerCompilerPass());
$containerBuilder->compile();


// Setup CLI with commands

$commands = [
    new SimulateContactsGetCommand(),
    new SimulateContactsUpdateCommand(),
    new SimulatePaymentsGetCommand(),
    new SimulatePaymentsUpdateCommand(),
];

$application = new Application();
foreach ($commands as $command) {
    $command->setContainer($containerBuilder);
    $application->add($command);
}

// Run CLI
$application->run();