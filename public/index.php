<?php 
include '../autoload.php';

$definitions = new \Config\Di\Definitions();
$container = $definitions->getContainerWithDefinitions();
$bootstrap = $container->get(\Core\Api\BootstrapInterface::class);
$bootstrap->run();
