<?php

declare(strict_types=1);

namespace Dino\Play;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__.'/../vendor/autoload.php';

$container = new ContainerBuilder();

$loggerDefinition = new Definition('Monolog\Logger');
$loggerDefinition->setArguments(
    [
        'main',
        [
            new Reference('logger.stream_handler')
        ]
    ]
);

$loggerDefinition->addMethodCall(
    'pushHandler',
    [
        new Reference('logger.std_out_handler')
    ]
);

$loggerDefinition->addMethodCall(
    'debug',
    [
        'The logger just got started'
    ]
);

$container->setDefinition('logger', $loggerDefinition);

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
