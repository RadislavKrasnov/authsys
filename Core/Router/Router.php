<?php

namespace Core\Router;

use Core\Api\Router\RouterInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RouteInterface;

/**
 * Class Router
 * @package Core\Router
 */
class Router implements RouterInterface
{
    /**
     * Get routes
     *
     * @var
     */
    private $routes;

    /**
     * Post routes
     *
     * @var
     */
    private $postRoutes;

    /**
     * Add get route
     *
     * @param RouteInterface $route
     * @return \Core\Api\Router\RouterInterface
     */
    public function addGet(RouteInterface $route)
    {
        $this->routes[] = $route;

        return $this;
    }

    /**
     * Add post route
     *
     * @param RouteInterface $route
     * @return \Core\Api\Router\RouterInterface
     */
    public function addPost(RouteInterface $route)
    {
        $this->postRoutes[] = $route;

        return $this;
    }

    /**
     * Get routes for Get request
     *
     * @return array
     */
    public function getRoutes() :array
    {
        return $this->routes;
    }

    /**
     * Get routes for Post request
     *
     * @return array
     */
    public function getPostRoutes() :array
    {
        return $this->postRoutes;
    }

    /**
     * Get route to dispatch
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Core\Api\Router\RouteInterface
     */
    public function route(RequestInterface $request, ResponseInterface $response)
    {
        if ($request->getRequestMethod() === RouterInterface::GET_REQUEST) {
            return $this->findRoute($this->routes, $request, $response);
        }

        if ($request->getRequestMethod() === RouterInterface::POST_REQUEST) {
            return $this->findRoute($this->postRoutes, $request, $response);
        }

        $response->addHeader('405 Method Not Allowed')->send();
        throw new \OutOfRangeException('The request method not allowed');
    }

    /**
     * Find route
     *
     * @param $routes
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return \Core\Api\Router\RouteInterface
     */
    private function findRoute($routes, RequestInterface $request, ResponseInterface $response)
    {
        foreach ($routes as $route) {
            if ($route->match($request)) {
                return $route;
            }
        }

        $response->addHeader('404 Page Not Found')->send();
        throw new \OutOfRangeException('The request doesn\'t match any URL');
    }
}
