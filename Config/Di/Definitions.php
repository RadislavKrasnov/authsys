<?php

namespace Config\Di;

use Core\Di\Container;

/**
 * Class Definitions
 * @package Config\Di
 */
class Definitions
{
    /**
     * @return Container
     */
    public function getContainerWithDefinitions()
    {
        $container = new Container();
        $container = $this->setDefinitions($container);

        return $container;
    }

    /**
     * @param Container $container
     * @return Container
     */
    protected function setDefinitions($container)
    {
        $container->set(\Core\Api\Url\UrlInterface::class, function () {
            return new \Core\Model\Url\Url();
        });
        $container->set(\Core\Api\Di\NotFoundExceptionInterface::class, function () {
            return new \Core\Di\NotFoundException();
        });
        $container->set(\Core\Api\Router\DispatcherInterface::class, function () {
            return new \Core\Router\Dispatcher();
        });
        $container->set(\Core\Api\Router\RouteInterface::class, function (Container $container) {
            $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

            return new \Core\Router\Route($urlParser);
        });
        $container->set(\Core\Api\Router\RouteFactoryInterface::class, function (Container $container) {
            $route = $container->get(\Core\Api\Router\RouteInterface::class);
            $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

            return new \Core\Router\RouteFactory($route, $urlParser);
        });
        $container->set(\Core\Api\Router\RouterInterface::class, function (Container $container) {
            $routeFactory = $container->get(\Core\Api\Router\RouteFactoryInterface::class);

            return new \Core\Router\Router($routeFactory);
        });
        $container->set(\Core\Api\BootstrapInterface::class, function (Container $container) {
            $dispatcher = $container->get(\Core\Api\Router\DispatcherInterface::class);
            $request = $container->get(\Core\Api\Router\RequestInterface::class);
            $response = $container->get(\Core\Api\Router\ResponseInterface::class);
            $router = $container->get(\Core\Api\Router\RouterInterface::class);

            return new \Core\Bootstrap($dispatcher, $request, $response, $router);
        });
        $container->share(\Core\Api\Di\ContainerInterface::class, function () {
            return new \Core\Di\Container();
        });
        $container->share(\Core\Api\Router\RequestInterface::class, function (Container $container) {
            $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

            return new \Core\Router\Request($urlParser);
        });
        $container->share(\Core\Api\Router\ResponseInterface::class, function () {
            return new \Core\Router\Response();
        });

        return $container;
    }
}
