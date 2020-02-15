<?php

namespace Core\Router;

use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Router\RouterInterface;
use Core\Api\Router\ResponseInterface;

/**
 * Class Dispatcher
 * @package Core\Router
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * Dispatcher of requests to controller's action
     *
     * @param RouteInterface $route
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed|void
     */
    public function dispatch(RouteInterface $route, RequestInterface $request, ResponseInterface $response)
    {
        $controller = $route->createController();
        $action = $route->getAction();

        if ($request->getRequestMethod() === RouterInterface::POST_REQUEST) {
            echo $controller->{$action}($request, $response);
        }

        $controller->{$action}($request, $response);
    }
}
