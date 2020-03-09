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
     * @var string
     */
    private $path;

    /**
     * Controller class
     *
     * @var string
     */
    private $controller;

    /**
     * Controller action
     *
     * @var string
     */
    private $action;

    /**
     * Set path
     *
     * @param string $path
     * @return \Core\Api\Router\RouteInterface
     */
    public function setPath(string $path): object
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set controller
     *
     * @param string $controller
     * @return \Core\Api\Router\RouteInterface
     */
    public function setController(string $controller): object
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * Set action
     *
     * @param string $action
     * @return \Core\Api\Router\RouteInterface
     */
    public function setAction(string $action): object
    {
        $this->action = $action;

        return $this;
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
