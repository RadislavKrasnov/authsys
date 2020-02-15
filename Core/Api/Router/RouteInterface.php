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
