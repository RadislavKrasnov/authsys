<?php

namespace Core\Router;

use Core\Api\Router\RouteInterface;
use Core\Api\Router\RequestInterface;
use Core\Model\Url\Url;

/**
 * Class Route
 * @package Core\Router
 */
class Route implements RouteInterface
{
    /**
     * Route path
     *
     * @var
     */
    private $path;

    /**
     * Controller class
     *
     * @var
     */
    private $controller;

    /**
     * Controller action
     *
     * @var
     */
    private $action;

    /**
     * Route constructor.
     *
     * @param $path
     * @param $controller
     * @param $action
     */
    public function __construct($path, $controller, $action)
    {
        $this->path = $path;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * Create controller
     *
     * @return mixed
     */
    public function createController()
    {
        return new $this->controller();
    }

    /**
     * Get action
     *
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Get route by matching requested Url and path Url from routes
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request) :bool
    {
        if (Url::matchPathAndRequestUrl($this->path, $request->getUrl())) {
            $urlParams = Url::parseParams($this->path, $request->getUrl());
            $request->setParams($urlParams);

            return true;
        }

        return false;
    }
}
