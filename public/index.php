<?php 
include '../autoload.php';

$container = new \Core\Di\Container();
$definitions = new \Config\Di\Definitions();
$container = $definitions->getContainerWithDefinitions($container);
$bootstrap = $container->get(\Core\Api\BootstrapInterface::class);
$bootstrap->run();
