<?php

namespace Core\Router;

use Core\Api\Router\RouterInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Router\RouteFactoryInterface;

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
    private $getRoutes;

    /**
     * Post routes
     *
     * @var
     */
    private $postRoutes;

    /**
     * @var RouteFactoryInterface
     */
    private $routeFactory;

    /**
     * Router constructor.
     * @param RouteFactoryInterface $routeFactory
     */
    public function __construct(RouteFactoryInterface $routeFactory)
    {
        $this->routeFactory = $routeFactory;
    }

    /**
     * Add get route
     *
     * @param RouteInterface $route
     * @return \Core\Api\Router\RouterInterface
     */
    public function addGet(RouteInterface $route)
    {
        $this->getRoutes[] = $route;

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
     * Set routes
     *
     * @param array $routes
     * @return \Core\Api\Router\RouterInterface
     */
    public function setRoutes(array $routes): object
    {
        foreach ($routes as $routeData) {

            if (
                !array_key_exists('request_method', $routeData) ||
                !array_key_exists('path', $routeData) ||
                !array_key_exists('controller', $routeData) ||
                !array_key_exists('action', $routeData)
            ) {
                continue;
            }

            $route = $this->routeFactory->create();
            $route->setPath($routeData['path']);
            $route->setController($routeData['controller']);
            $route->setAction($routeData['action']);

            if ($routeData['request_method'] === RouterInterface::GET_REQUEST) {
                $this->addGet($route);
            }

            if ($routeData['request_method'] === RouterInterface::POST_REQUEST) {
                $this->addPost($route);
            }
        }

        return $this;
    }

    /**
     * Get routes for Get request
     *
     * @return array
     */
    public function getGetRoutes() :array
    {
        return $this->getRoutes;
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
            return $this->findRoute($this->getGetRoutes(), $request, $response);
        }

        if ($request->getRequestMethod() === RouterInterface::POST_REQUEST) {
            return $this->findRoute($this->getPostRoutes(), $request, $response);
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
