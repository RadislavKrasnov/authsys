<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Router\Dispatcher;
use Core\Router\Response;
use Core\Router\Request;

class Bootstrap implements BootstrapInterface
{
    private $request;

    private $response;

    private $router;

    private $dispatcher;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new \Routes\Routes();
        $this->dispatcher = new Dispatcher();
    }

    public function run()
    {
        $router = $this->router->getRouter();
        $route = $router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request, $this->response);
    }
}