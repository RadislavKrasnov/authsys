<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Api\Router\ResponseInterface;
use Core\Router\Dispatcher;
use Core\Router\Response;
use Core\Router\Request;
use Core\Model\Url\Url;

class Bootstrap implements BootstrapInterface
{
    private $request;

    private $response;

    private $router;

    private $dispatcher;

    private $url;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new \Routes\Routes();
        $this->dispatcher = new Dispatcher();
        $this->url = new Url();
    }

    public function run()
    {
        $path = $this->url->parseUrl();
        $this->request->setUrl($path);
        $router = $this->router->getRouter();
        $this->response->setVersion(ResponseInterface::VERSION);
        $route = $router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request);
    }
}