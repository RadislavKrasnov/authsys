<?php

namespace Core\Api\Router;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RouteInterface;

/**
 * Interface RouterInterface
 * @package Core\Api\Router
 */
interface RouterInterface
{
    /**
     * Get request
     */
    const GET_REQUEST = 'GET';

    /**
     * Post request
     */
    const POST_REQUEST = 'POST';

    /**
     * Add get route
     *
     * @param \Core\Api\Router\RouteInterface $route
     * @return \Core\Api\Router\RouterInterface
     */
    public function addGet(RouteInterface $route);

    /**
     * Add post route
     *
     * @param \Core\Api\Router\RouteInterface $route
     * @return \Core\Api\Router\RouterInterface
     */
    public function addPost(RouteInterface $route);

    /**
     * Get routes for Get request
     *
     * @return array
     */
    public function getRoutes() :array;

    /**
     * Get routes for Post request
     *
     * @return array
     */
    public function getPostRoutes() :array;

    /**
     * Get route to dispatch
     *
     * @param \Core\Api\Router\RequestInterface $request
     * @param \Core\Api\Router\ResponseInterface $response
     * @return \Core\Api\Router\RouteInterface
     */
    public function route(RequestInterface $request, ResponseInterface $response);
}
