<?php 
include '../autoload.php';

$container = new \Core\Di\Container();
$container->setDefinitions(\Config\Di\Definitions::getDefinitions());
$container->setSingletons(\Config\Di\Definitions::getSingletons());
$bootstrap = $container->get(\Core\Bootstrap::class);
$bootstrap->run();
