<?php

namespace Routes;

use Core\Router\Router;
use Core\Router\Route;

/**
 * Class Routes
 * @package Routes
 */
class Routes
{
    /**
     * @var Router
     */
    private $router;

    /**
     * Routes constructor.
     */
    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Get routes of application
     *
     * @return Router
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
