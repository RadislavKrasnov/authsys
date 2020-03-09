<?php

namespace Core\Api\Router;

use Core\Api\Router\RequestInterface;

/**
 * Interface RouteInterface
 * @package Core\Api\Router
 */
interface RouteInterface
{
    /**
     * Set path
     *
     * @param string $path
     * @return \Core\Api\Router\RouteInterface
     */
    public function setPath(string $path): object ;

    /**
     * Set controller
     *
     * @param string $controller
     * @return \Core\Api\Router\RouteInterface
     */
    public function setController(string $controller): object ;

    /**
     * Set action
     *
     * @param string $action
     * @return \Core\Api\Router\RouteInterface
     */
    public function setAction(string $action): object ;

    /**
     * Create controller
     *
     * @return mixed
     */
    public function createController();

    /**
     * Get action
     *
     * @return mixed
     */
    public function getAction();

    /**
     * Get route by matching requested Url and path Url from routes
     *
     * @param \Core\Api\Router\RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request) :bool;
}
