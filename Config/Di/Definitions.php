<?php

namespace Config\Di;

/**
 * Class Definitions
 * @package Config\Di
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
            \Core\Api\Url\UrlInterface::class => function () {
                return new \Core\Model\Url\Url();
            },
            \Core\Api\Di\NotFoundExceptionInterface::class => function () {
                return new \Core\Di\NotFoundException();
            },
            \Core\Api\Router\DispatcherInterface::class => function () {
                return new \Core\Router\Dispatcher();
            },
            \Core\Api\Router\RouteInterface::class => function () {
                return new \Core\Router\Route();
            },
            \Core\Api\Router\RouteFactoryInterface::class => function () {
                $route = self::getDefinitions()[\Core\Api\Router\RouteInterface::class]();
                return new \Core\Router\RouteFactory($route);
            },
            \Core\Api\Router\RouterInterface::class => function () {
                $routeFactory = self::getDefinitions()[\Core\Api\Router\RouteFactoryInterface::class]();
                return new \Core\Router\Router($routeFactory);
            },
            \Core\Api\BootstrapInterface::class => function () {
                $dispatcher =self::getDefinitions()[\Core\Api\Router\DispatcherInterface::class]();
                $request = self::getSingletons()[\Core\Api\Router\RequestInterface::class]();
                $response = self::getSingletons()[\Core\Api\Router\ResponseInterface::class]();
                $router = self::getDefinitions()[\Core\Api\Router\RouterInterface::class]();

                return new \Core\Bootstrap($dispatcher, $request, $response, $router);
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
