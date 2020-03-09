<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouterInterface;
use Routes\RouteList;

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
     * Bootstrap constructor.
     * @param DispatcherInterface $dispatcher
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param RouterInterface $router
     */
    public function __construct(
        DispatcherInterface $dispatcher,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $router
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->dispatcher = $dispatcher;
        $this->router = $router;
    }

    /**
     * Run bootstrap (Front Controller)
     *
     * @return mixed|void
     */
    public function run()
    {
        $routes = RouteList::getRoutes();
        $this->router->setRoutes($routes);
        $route = $this->router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request, $this->response);
    }
}
