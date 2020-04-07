<?php

namespace Core\Router;

use Core\Api\Router\RouteListInterface;
use Core\Config\DevelopmentConfig;

/**
 * Class RouteList
 * @package Core\Router
 */
class RouteList implements RouteListInterface
{
    /**
     * @var DevelopmentConfig
     */
    private $developmentConfig;

    /**
     * RouteList constructor.
     *
     * @param DevelopmentConfig $developmentConfig
     */
    public function __construct(
        DevelopmentConfig $developmentConfig
    ) {
        $this->developmentConfig = $developmentConfig;
    }

    /**
     * Get routes from file
     *
     * @return array
     * @throws \Exception
     */
    public function getRoutes(): array
    {
        return $this->developmentConfig->loadConfigFile(RouteListInterface::ROUTES_FILE);
    }
}
