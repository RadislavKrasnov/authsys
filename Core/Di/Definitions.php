<?php

namespace Core\Di;

/**
 * Class Definitions
 * @package Core\Di
 */
class Definitions
{
    /**
     * Get array of definitions
     *
     * @return array
     */
    public static function getDefinitions()
    {
        return [
            \Core\Api\Router\DispatcherInterface::class => function () {
                return new \Core\Router\Dispatcher();
            },
            \Core\Api\Router\RouterInterface::class => function () {
                return new \Core\Router\Router();
            },
            \Core\Api\Router\RouteInterface::class => function () {
                return new \Core\Router\Route(
                    '/profile',
                    '\App\Controller\Users\User',
                    'show'
                );
            },
            \Core\Api\BootstrapInterface::class => function () {
                $dispatcher = new \Core\Router\Dispatcher();
                $request = new \Core\Router\Request();
                $response = new \Core\Router\Response();
                $router = new \Core\Router\Router();
                $routes = new \Routes\Routes($router);

                return new \Core\Bootstrap($dispatcher, $request, $response, $routes);
            }
        ];
    }

    /**
     * Get array of singletons
     *
     * @return array
     */
    public static function getSingletons()
    {
        return [
            \Core\Api\Di\ContainerInterface::class => function () {
                return new \Core\Di\Container();
            },
            \Core\Api\Router\RequestInterface::class => function () {
                return new \Core\Router\Request();
            },
            \Core\Api\Router\ResponseInterface::class => function () {
                return new \Core\Router\Response();
            }
        ];
    }
}
