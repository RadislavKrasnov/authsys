<?php

namespace Core\Api\Router;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Router\ResponseInterface;

/**
 * Interface DispatcherInterface
 * @package Core\Api\Router
 */
interface DispatcherInterface
{
    /**
     * Dispatcher of requests to controller's action
     *
     * @param \Core\Api\Router\RouteInterface $route
     * @param \Core\Api\Router\RequestInterface $request
     * @param \Core\Api\Router\ResponseInterface $response
     * @return mixed
     */
    public function dispatch(RouteInterface $route, RequestInterface $request, ResponseInterface $response);
}
