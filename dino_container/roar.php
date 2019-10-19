<?php

declare(strict_types=1);

namespace Dino\Play;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

require __DIR__.'/../vendor/autoload.php';

$container = new ContainerBuilder();
$container->setParameter('root_dir', __DIR__);

$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.yml');

//-------------------------------------------------------

runApp($container);

function runApp(ContainerBuilder $container)
{
    $container->get('logger')->info('ROOOOOAR');
}
