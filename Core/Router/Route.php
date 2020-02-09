<?php

namespace Core\Router;

use Core\Api\Router\RouteInterface;
use Core\Api\Router\RequestInterface;

class Route implements RouteInterface
{
    private $path;

    private $controller;

    private $action;

    public function __construct($path, $controller, $action)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    public function createController()
    {
        return new $this->controller();
    }

    public function getAction()
    {
        return $this->action;
    }

    public function match(RequestInterface $request)
    {
        return $this->path === $request->getUrl();
    }
}
