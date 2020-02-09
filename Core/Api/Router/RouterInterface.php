<?php

namespace Core\Api\Router;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RouteInterface;

interface RouterInterface
{
    const GET_REQUEST = 'GET';

    const POST_REQUEST = 'POST';

    public function addGet(RouteInterface $route);

    public function addPost(RouteInterface $route);

    public function getRoutes();

    public function getPostRoutes();

    public function route(RequestInterface $request, ResponseInterface $response);
}
