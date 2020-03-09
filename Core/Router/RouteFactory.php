<?php

namespace Core\Router;

use Core\Api\Router\RouteFactoryInterface;
use Core\Api\Router\RouteInterface;

/**
 * Class RouteFactory
 * @package Core\Router
 */
class RouteFactory implements RouteFactoryInterface
{
    /**
     * @var string
     */
    private $routeClassName;

    /**
     * RouteFactory constructor.
     * @param RouteInterface $routeClass
     */
    public function __construct(
        RouteInterface $routeClass
    ) {
        $this->routeClassName = get_class($routeClass);
    }

    /**
     * Create new instance of route class
     *
     * @return object
     */
    public function create(): object
    {
        return new $this->routeClassName;
    }
}
