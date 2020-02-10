<?php

namespace Routes;

use Core\Router\Router;
use Core\Router\Route;

class Routes
{
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function getRouter()
    {
        $this->router->addGet(
            new Route(
            '/{id}',
            '\App\Controller\Profile\Index',
            'index'
            )
        );

        $this->router->addGet(
            new Route(
                '/',
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
