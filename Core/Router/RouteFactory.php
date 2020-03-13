<?php

namespace Core\Router;

use Core\Api\Router\RouteFactoryInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Url\UrlInterface;

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
     * @var UrlInterface
     */
    private $urlParser;

    /**
     * RouteFactory constructor.
     * @param RouteInterface $routeClass
     * @param UrlInterface $urlParser
     */
    public function __construct(
        RouteInterface $routeClass,
        UrlInterface $urlParser
    ) {
        $this->urlParser = $urlParser;
        $this->routeClassName = get_class($routeClass);
    }

    /**
     * Create new instance of route class
     *
     * @return object
     */
    public function create(): object
    {
        return new $this->routeClassName($this->urlParser);
    }
}
