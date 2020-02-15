<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Router\Dispatcher;
use Core\Router\Response;
use Core\Router\Request;

/**
 * Class Bootstrap
 * @package Core
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var \Routes\Routes
     */
    private $router;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * Bootstrap constructor.
     */
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new \Routes\Routes();
        $this->dispatcher = new Dispatcher();
    }

    /**
     * Run bootstrap (Front Controller)
     *
     * @return mixed|void
     */
    public function run()
    {
        $router = $this->router->getRouter();
        $route = $router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request, $this->response);
    }
}