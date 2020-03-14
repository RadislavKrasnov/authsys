<?php

namespace Core\Di;

use \Core\Api\Di\DiManagerInterface;
use \Core\Api\Di\ContainerInterface;
use \Core\Api\Di\DefinitionsInterface;

/**
 * Class DiManager
 * @package Core\Di
 */
class DiManager implements  DiManagerInterface
{
    /**
     * @var DefinitionsInterface
     */
    private $definitions;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * DiFactory constructor.
     * @param DefinitionsInterface $definitions
     * @param ContainerInterface $container
     */
    public function __construct(
        DefinitionsInterface $definitions,
        ContainerInterface $container
    ) {
        $this->definitions = $definitions;
        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function create(): object
    {
         $container = $this->definitions->getContainerWithDefinitions($this->container);

         return $container;
    }
}
