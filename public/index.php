<?php 
include '../autoload.php';

$container = new \Core\Di\Container();
$container->setDefinitions(\Core\Di\Definitions::getDefinitions());
$container->setSingletons(\Core\Di\Definitions::getSingletons());
$bootstrap = $container->get(\Core\Bootstrap::class);
$bootstrap->run();
