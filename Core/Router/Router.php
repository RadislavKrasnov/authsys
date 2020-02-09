<?php

namespace Core\Router;

use Core\Api\Router\RouterInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RouteInterface;

class Router implements RouterInterface
{
    private $routes;

    private $postRoutes;

    public function addGet(RouteInterface $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    public function addPost(RouteInterface $route)
    {
        $this->postRoutes[] = $route;

        return $this;
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function getPostRoutes()
    {
        return $this->postRoutes;
    }

    public function route(RequestInterface $request, ResponseInterface $response)
    {
        if ($request->getRequestMethod() === RouterInterface::GET_REQUEST) {
            return $this->findRoute($this->routes, $request);
        }

        if ($request->getRequestMethod() === RouterInterface::POST_REQUEST) {
            return $this->findRoute($this->postRoutes, $request);
        }

        $response->addHeader('404 Page Not Found')->send();
        throw new \OutOfRangeException('The request doesn\'t match any URL');
    }

    private function findRoute($routes, RequestInterface $request)
    {
        foreach ($routes as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }
    }
}
