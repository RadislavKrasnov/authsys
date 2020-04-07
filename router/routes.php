<?php

return [
    [
        'request_method' => \Core\Api\Router\RouterInterface::GET_REQUEST,
        'path' => '/users/{id}/{lang}',
        'controller' => '\App\Controller\Profile\Index',
        'action' => 'index'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::GET_REQUEST,
        'path' => '/profile',
        'controller' => '\App\Controller\Users\User',
        'action' => 'show'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/users/user/show',
        'controller' => '\App\Controller\Users\UserPost',
        'action' => 'show'
    ]
];
