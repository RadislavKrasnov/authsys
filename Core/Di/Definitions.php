<?php

namespace Core\Di;

use Core\Api\Di\ContainerInterface;
use Core\Api\Di\DefinitionsInterface;
use Core\Api\Config\DevelopmentConfigInterface;

/**
 * Class Definitions
 * @package Config\Di
 */
class Definitions implements DefinitionsInterface
{
    /**
     * @var DevelopmentConfigInterface
     */
    private $developmentConfig;

    /**
     * Definitions constructor.
     *
     * @param DevelopmentConfigInterface $developmentConfig
     */
    public function __construct(
        DevelopmentConfigInterface $developmentConfig
    ) {
        $this->developmentConfig = $developmentConfig;
    }

    /**
     * @param ContainerInterface $container
     * @return object
     * @throws \Exception
     */
    public function getContainerWithDefinitions(ContainerInterface $container): object
    {
        $container = $this->setDefinitions($container);

        return $container;
    }

    /**
     * @param ContainerInterface $container
     * @return ContainerInterface
     * @throws \Exception
     */
    private function setDefinitions(ContainerInterface $container): object
    {
        $definitions = $this->developmentConfig->loadConfigFile(DefinitionsInterface::DEFINITIONS_CONFIG_FILE);

        foreach ($definitions as $definition => $closure) {
            $container->set($definition, $closure);
        }

        return $container;
    }
}
