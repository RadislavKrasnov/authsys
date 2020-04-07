<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouterInterface;
use Core\Api\Router\RouteListInterface;

/**
 * Class Bootstrap
 * @package Core
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * @var RouteListInterface
     */
    private $routeList;

    /**
     * Bootstrap constructor.
     *
     * @param DispatcherInterface $dispatcher
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param RouterInterface $router
     * @param RouteListInterface $routeList
     */
    public function __construct(
        DispatcherInterface $dispatcher,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $router,
        RouteListInterface $routeList
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->routeList = $routeList;
    }

    /**
     * Run bootstrap (Front Controller)
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $routes = $this->routeList->getRoutes();
        $this->router->setRoutes($routes);
        $route = $this->router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request, $this->response);
    }
}
