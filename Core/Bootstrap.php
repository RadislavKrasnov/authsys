<?php

namespace Core;

use Core\Api\BootstrapInterface;
use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouterInterface;
use Core\Api\Router\RouteListInterface;
use Core\Api\Config\DevelopmentConfigInterface;
use Core\Api\Database\Connection\MySqlConnectionInterface;
use Core\Database\ConnectionResolver;

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
     * @var DevelopmentConfigInterface
     */
    private $developmentConfig;

    /**
     * @var MySqlConnectionInterface
     */
    private $mySqlConnection;

    /**
     * Bootstrap constructor
     *
     * @param DispatcherInterface $dispatcher
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param RouterInterface $router
     * @param RouteListInterface $routeList
     * @param DevelopmentConfigInterface $developmentConfig
     * @param MySqlConnectionInterface $mySqlConnection
     */
    public function __construct(
        DispatcherInterface $dispatcher,
        RequestInterface $request,
        ResponseInterface $response,
        RouterInterface $router,
        RouteListInterface $routeList,
        DevelopmentConfigInterface $developmentConfig,
        MySqlConnectionInterface $mySqlConnection
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->dispatcher = $dispatcher;
        $this->router = $router;
        $this->routeList = $routeList;
        $this->developmentConfig = $developmentConfig;
        $this->mySqlConnection = $mySqlConnection;
    }

    /**
     * Run bootstrap (Front Controller)
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        ConnectionResolver::initializeConnections($this->developmentConfig, $this->mySqlConnection);
        $routes = $this->routeList->getRoutes();
        $this->router->setRoutes($routes);
        $route = $this->router->route($this->request, $this->response);
        $this->dispatcher->dispatch($route, $this->request, $this->response);
    }
}
