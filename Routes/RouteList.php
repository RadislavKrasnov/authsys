<?php

namespace Routes;

use Core\Api\Router\RouterInterface;

/**
 * Class RouteList
 * @package Routes
 */
class RouteList
{
    /**
     * Routes in application
     *
     * @return array
     */
    public static function getRoutes()
    {
        return [
            [
                'request_method' => RouterInterface::GET_REQUEST,
                'path' => '/users/{id}/{lang}',
                'controller' => '\App\Controller\Profile\Index',
                'action' => 'index'
            ],
            [
                'request_method' => RouterInterface::GET_REQUEST,
                'path' => '/profile',
                'controller' => '\App\Controller\Users\User',
                'action' => 'show'
            ],
            [
                'request_method' => RouterInterface::POST_REQUEST,
                'path' => '/users/user/show',
                'controller' => '\App\Controller\Users\UserPost',
                'action' => 'show'
            ]
        ];
    }
}
