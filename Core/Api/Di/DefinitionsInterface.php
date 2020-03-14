<?php

namespace Core\Api\Di;

use \Core\Api\Di\ContainerInterface;

/**
 * Interface DefinitionsInterface
 * @package Core\Api\Di
 */
interface DefinitionsInterface
{
    /**
     * @param ContainerInterface $container
     * @return ContainerInterface
     */
    public function getContainerWithDefinitions(ContainerInterface $container): object;
}
