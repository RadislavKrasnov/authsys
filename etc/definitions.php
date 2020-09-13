<?php

return [
    \App\Api\Authorization\AuthorizeInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $cookie = $container->get(\Core\Api\Cookie\CookieInterface::class);
        $session = $container->get(\Core\Api\Session\SessionInterface::class);
        $authtoken = $container->get(\App\Api\Authtoken\AuthtokenInterface::class);
        $tokenGenerator = $container->get(\App\Api\Authtoken\TokenGeneratorInterface::class);
        $logger = $container->get(\Core\Api\Psr\Log\LoggerInterface::class);

        return new \App\Model\Authorization\Authorize($cookie, $session, $authtoken, $tokenGenerator, $logger);
    },
    \App\Api\Authtoken\TokenGeneratorInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \App\Model\Authtoken\TokenGenerator();
    },
    \App\Api\Authtoken\AuthtokenInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);
        $builder = $container->get(\Core\Api\ActiveRecord\BuilderInterface::class);

        return new \App\Model\Authtoken\Authtoken($diManager, $builder);
    },
    \App\Api\User\UserInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);
        $builder = $container->get(\Core\Api\ActiveRecord\BuilderInterface::class);

        return new \App\Model\User($diManager, $builder);
    },
    \App\Api\Geo\CityInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);
        $builder = $container->get(\Core\Api\ActiveRecord\BuilderInterface::class);

        return new \App\Model\Geo\City($diManager, $builder);
    },
    \App\Api\Geo\RegionInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);
        $builder = $container->get(\Core\Api\ActiveRecord\BuilderInterface::class);

        return new \App\Model\Geo\Region($diManager, $builder);
    },
    \App\Api\Geo\CountryInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);
        $builder = $container->get(\Core\Api\ActiveRecord\BuilderInterface::class);

        return new \App\Model\Geo\Country($diManager, $builder);
    },
    \Core\Api\Messages\MessageManagerInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $session = $container->get(\Core\Api\Session\SessionInterface::class);

        return new \Core\Messages\MessageManager($session);
    },
    \Core\Api\Cookie\CookieInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \Core\Cookie\Cookie();
    },
    \Core\Api\Session\SessionInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \Core\Session\Session();
    },
    \Core\Api\Url\RedirectInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \Core\Url\Redirect();
    },
    \Core\Api\Psr\Log\LoggerInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \Core\Psr\Log\Logger();
    },
    \Core\Api\Validation\ValidatorInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \Core\Validation\Validator();
    },
    \Core\Api\View\ViewServiceProviderInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        return new \App\Provider\View\ViewServiceProvider();
    },
    \Core\Api\View\ViewInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);
        $viewServiceProvider = $container->get(\Core\Api\View\ViewServiceProviderInterface::class);

        return new \Core\View\View($diManager, $viewServiceProvider);
    },
    \Core\Api\Controllers\ControllerInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $view = $container->get(\Core\Api\View\ViewInterface::class);
        $session = $container->get(\Core\Api\Url\RedirectInterface::class);
        $redirect = $container->get(\Core\Api\Url\RedirectInterface::class);

        return new \Core\Controllers\Controller($view, $session, $redirect);
    },
    \Core\Api\ActiveRecord\BuilderInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $diManager = $container->get(\Core\Api\Di\DiManagerInterface::class);

        return new \Core\ActiveRecord\Builder($diManager);
    },
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
        $session = $container->get(\Core\Api\Session\SessionInterface::class);

        return new \Core\Bootstrap(
            $dispatcher,
            $request,
            $response,
            $router,
            $routeList,
            $developmentConfig,
            $mySqlConnection,
            $session
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
    \Core\Api\Di\DiManagerInterface::class => function (\Core\Api\Di\ContainerInterface $container) {
        $definitions = $container->get(\Core\Api\Di\DefinitionsInterface::class);
        $container = $container->get(\Core\Api\Di\ContainerInterface::class);

        return new \Core\Di\DiManager($definitions, $container);
    }
];
