<?php

namespace Core\Api\Di;

use \Core\Api\Di\ContainerInterface;

/**
 * Interface DefinitionsInterface
 * @package Core\Api\Di
 */
interface DefinitionsInterface
{
    const DEFINITIONS_CONFIG_FILE = '../etc/definitions.php';

    /**
     * @param ContainerInterface $container
     * @return ContainerInterface
     * @throws \Exception
     */
    public function getContainerWithDefinitions(ContainerInterface $container): object;
}
