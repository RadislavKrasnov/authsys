<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RequestInterface;
use Routes\Routes;

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
     * @var Routes
     */
    private $routes;

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * Bootstrap constructor.
     * @param DispatcherInterface $dispatcher
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param Routes $routes
     */
    public function __construct(
        DispatcherInterface $dispatcher,
        RequestInterface $request,
        ResponseInterface $response,
        Routes $routes
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->dispatcher = $dispatcher;
        $this->routes = $routes;
    }

    /**
     * Run bootstrap (Front Controller)
     *
     * @return mixed|void
     */
    public function run()
    {
        $router = $this->routes->getRouter();
        $route = $router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request, $this->response);
    }
}