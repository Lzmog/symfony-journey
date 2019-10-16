<?php

declare(strict_types=1);

namespace Dino\Play;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__.'/../vendor/autoload.php';

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.yml');

//-------------------------------------------------------

$handlerDefinition = new Definition('Monolog\Handler\StreamHandler');
$handlerDefinition->setArguments(
    [
        __DIR__.'/din.log'
    ]
);

$container->setDefinition('logger.stream_handler', $handlerDefinition);

//-------------------------------------------------------

$stdOutLoggerDefinition = new Definition('Monolog\Handler\StreamHandler');
$stdOutLoggerDefinition->setArguments(
    [
        'php://stdout'
    ]
);
$container->setDefinition('logger.std_out_handler', $stdOutLoggerDefinition);

//-------------------------------------------------------

runApp($container);

function runApp(ContainerBuilder $container)
{
    $container->get('logger')->info('ROOOOOAR');
}
