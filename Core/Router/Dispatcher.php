<?php

namespace Core\Router;

use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Router\RouterInterface;

class Dispatcher implements DispatcherInterface
{
    public function dispatch(RouteInterface $route, RequestInterface $request)
    {
        $controller = $route->createController();
        $action = $route->getAction();

        if ($request->getRequestMethod() === RouterInterface::POST_REQUEST) {
            echo $controller->{$action}();
        }

        $controller->{$action}();
    }
}
