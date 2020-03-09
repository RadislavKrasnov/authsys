<?php

namespace Routes;

use Core\Api\Router\RouterInterface;
use Core\Router\Route;

/**
 * Class Routes
 * @package Routes
 */
class Routes
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Routes constructor.
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter()
    {
        $this->router->addGet(
            new Route(
            '/users/{id}/{lang}',
            '\App\Controller\Profile\Index',
            'index'
            )
        );

        $this->router->addGet(
            new Route(
                '/profile',
                '\App\Controller\Users\User',
                'show'
            )
        );

        $this->router->addPost(
            new Route(
                '/users/user/show',
                '\App\Controller\Users\UserPost',
                'show'
            )
        );

        return $this->router;
    }
}
