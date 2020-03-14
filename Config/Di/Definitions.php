<?php

namespace Config\Di;

use Core\Api\Di\ContainerInterface;
use Core\Api\Di\DefinitionsInterface;

/**
 * Class Definitions
 * @package Config\Di
 */
class Definitions implements DefinitionsInterface
{
    /**
     * @param ContainerInterface $container
     * @return ContainerInterface
     */
    public function getContainerWithDefinitions(ContainerInterface $container): object
    {
        $container = $this->setDefinitions($container);

        return $container;
    }

    /**
     * @param ContainerInterface $container
     * @return ContainerInterface
     */
    private function setDefinitions(ContainerInterface $container): object
    {
        $container->set(\Core\Api\Di\DefinitionsInterface::class, function () {
            return new \Config\Di\Definitions();
        });
        $container->set(\Core\Api\Url\UrlInterface::class, function () {
            return new \Core\Model\Url\Url();
        });
        $container->set(\Core\Api\Di\NotFoundExceptionInterface::class, function () {
            return new \Core\Di\NotFoundException();
        });
        $container->set(\Core\Api\Router\DispatcherInterface::class, function (ContainerInterface $container) {
            $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);

            return new \Core\Router\Dispatcher($diManager);
        });
        $container->set(\Core\Api\Router\RouteInterface::class, function (ContainerInterface $container) {
            $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

            return new \Core\Router\Route($urlParser);
        });
        $container->set(\Core\Api\Router\RouteFactoryInterface::class, function (ContainerInterface $container) {
            $route = $container->get(\Core\Api\Router\RouteInterface::class);
            $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

            return new \Core\Router\RouteFactory($route, $urlParser);
        });
        $container->set(\Core\Api\Router\RouterInterface::class, function (ContainerInterface $container) {
            $routeFactory = $container->get(\Core\Api\Router\RouteFactoryInterface::class);

            return new \Core\Router\Router($routeFactory);
        });
        $container->set(\Core\Api\BootstrapInterface::class, function (ContainerInterface $container) {
            $dispatcher = $container->get(\Core\Api\Router\DispatcherInterface::class);
            $request = $container->get(\Core\Api\Router\RequestInterface::class);
            $response = $container->get(\Core\Api\Router\ResponseInterface::class);
            $router = $container->get(\Core\Api\Router\RouterInterface::class);

            return new \Core\Bootstrap($dispatcher, $request, $response, $router);
        });
        $container->share(\Core\Api\Di\ContainerInterface::class, function () {
            return new \Core\Di\Container();
        });
        $container->share(\Core\Api\Router\RequestInterface::class, function (ContainerInterface $container) {
            $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

            return new \Core\Router\Request($urlParser);
        });
        $container->share(\Core\Api\Router\ResponseInterface::class, function () {
            return new \Core\Router\Response();
        });
        $container->set(\App\Api\User\UserInterface::class, function() {
            return new \App\Model\User();
        });
        $container->set(\Core\Api\Di\DiManagerInterface::class, function (ContainerInterface $container) {
            $definitions = $container->get(\Core\Api\Di\DefinitionsInterface::class);
            $container = $container->get(\Core\Api\Di\ContainerInterface::class);

            return new \Core\Di\DiManager($definitions, $container);
        });

        return $container;
    }
}
