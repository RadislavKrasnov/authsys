<?php

return [
    \Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface::class => function () {
        return new \Core\Database\QueryBuilder\MySqlQueryBuilder();
    },
    \Core\Api\Database\Connection\MySqlConnectionInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $mySqlQueryBuilder = $container->get(\Core\Api\Database\QueryBuilder\MySqlQueryBuilderInterface::class);

        return new \Core\Database\Connection\MySqlConnection($mySqlQueryBuilder);
    },
    \Core\Api\Config\DevelopmentConfigInterface::class => function () {
        return new \Core\Config\DevelopmentConfig();
    },
    \Core\Api\Router\RouteListInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $developmentConfig = $container->get(\Core\Api\Config\DevelopmentConfigInterface::class);

        return new \Core\Router\RouteList($developmentConfig);
    },
    \Core\Api\Di\DefinitionsInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $developmentConfig = $container->get(\Core\Api\Config\DevelopmentConfigInterface::class);

        return new \Core\Di\Definitions($developmentConfig);
    },
    \Core\Api\Url\UrlInterface::class => function () {
        return new \Core\Url\Url();
    },
    \Core\Api\Di\NotFoundExceptionInterface::class => function () {
        return new \Core\Di\NotFoundException();
    },
    \Core\Api\Router\DispatcherInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);

        return new \Core\Router\Dispatcher($diManager);
    },
    \Core\Api\Router\RouteInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

        return new \Core\Router\Route($urlParser);
    },
    \Core\Api\Router\RouteFactoryInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $route = $container->get(\Core\Api\Router\RouteInterface::class);
        $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

        return new \Core\Router\RouteFactory($route, $urlParser);
    },
    \Core\Api\Router\RouterInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $routeFactory = $container->get(\Core\Api\Router\RouteFactoryInterface::class);

        return new \Core\Router\Router($routeFactory);
    },
    \Core\Api\BootstrapInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $dispatcher = $container->get(\Core\Api\Router\DispatcherInterface::class);
        $request = $container->get(\Core\Api\Router\RequestInterface::class);
        $response = $container->get(\Core\Api\Router\ResponseInterface::class);
        $router = $container->get(\Core\Api\Router\RouterInterface::class);
        $routeList = $container->get(\Core\Api\Router\RouteListInterface::class);
        $developmentConfig = $container->get(\Core\Api\Config\DevelopmentConfigInterface::class);
        $mySqlConnection = $container->get(\Core\Api\Database\Connection\MySqlConnectionInterface::class);

        return new \Core\Bootstrap(
            $dispatcher,
            $request,
            $response,
            $router,
            $routeList,
            $developmentConfig,
            $mySqlConnection
        );
    },
    \Core\Api\Di\ContainerInterface::class => function () {
        return new \Core\Di\Container();
    },
    \Core\Api\Router\RequestInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $urlParser = $container->get(\Core\Api\Url\UrlInterface::class);

        return new \Core\Router\Request($urlParser);
    },
    \Core\Api\Router\ResponseInterface::class => function () {
        return new \Core\Router\Response();
    },
    \App\Api\User\UserInterface::class => function() {
        return new \App\Model\User();
    },
    \Core\Api\Di\DiManagerInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $definitions = $container->get(\Core\Api\Di\DefinitionsInterface::class);
        $container = $container->get(\Core\Api\Di\ContainerInterface::class);

        return new \Core\Di\DiManager($definitions, $container);
    }
];
