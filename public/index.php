<?php 
include '../autoload.php';

$container = new \Core\Di\Container();
$developmentConfig = new \Core\Config\DevelopmentConfig();
$definitions = new \Core\Di\Definitions($developmentConfig);
$container = $definitions->getContainerWithDefinitions($container);
$bootstrap = $container->get(\Core\Api\BootstrapInterface::class);
$bootstrap->run();
