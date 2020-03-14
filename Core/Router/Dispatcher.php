<?php

namespace Core\Router;

use Core\Api\Router\DispatcherInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\RouteInterface;
use Core\Api\Router\RouterInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Di\DiManagerInterface;

/**
 * Class Dispatcher
 * @package Core\Router
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var DiManagerInterface
     */
    private $diManager;

    /**
     * Dispatcher constructor.
     * @param DiManagerInterface $diManager
     */
    public function __construct(DiManagerInterface $diManager)
    {
        $this->diManager = $diManager;
    }

    /**
     * Dispatcher of requests to controller's action
     *
     * @param RouteInterface $route
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return mixed|void
     */
    public function dispatch(RouteInterface $route, RequestInterface $request, ResponseInterface $response)
    {
        $container = $this->diManager->create();
        $controller = $container->get($route->createController());
        $action = $route->getAction();

        if ($request->getRequestMethod() === RouterInterface::POST_REQUEST) {
            echo $controller->{$action}($request, $response);
        }

        $controller->{$action}($request, $response);
    }
}
