<?php

namespace Core\Api\Router;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Router\ResponseInterface;

interface DispatcherInterface
{
    public function dispatch(RouteInterface $route, RequestInterface $request, ResponseInterface $response);
}
