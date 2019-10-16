<?php

declare(strict_types=1);

namespace Dino\Play;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require __DIR__.'/../vendor/autoload.php';

$container = new ContainerBuilder();

$streamHandler = new StreamHandler(__DIR__.'/din.log');
$container->set('logger.stream_handler', $streamHandler);

$logger = new Logger(
    'main',
    [
        $container->get('logger.stream_handler')
    ]
);

$container->set('logger', $logger);
runApp($container);

function runApp(ContainerBuilder $container)
{
    $container->get('logger')->info('ROOOOOAR');
}


