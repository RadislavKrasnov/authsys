<?php

namespace Core\Router;

use Core\Api\Router\RouteInterface;
use Core\Api\Router\RequestInterface;
use Core\Model\Url\Url;

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
        if (Url::matchPathAndRequestUrl($this->path, $request->getUrl())) {
            $urlParams = Url::parseParams($this->path, $request->getUrl());
            $request->setParams($urlParams);

            return true;
        }

        return false;
    }
}
