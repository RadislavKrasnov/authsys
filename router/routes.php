<?php

return [
    [
        'request_method' => \Core\Api\Router\RouterInterface::GET_REQUEST,
        'path' => '/',
        'controller' => '\App\Controller\Auth\Index',
        'action' => 'index'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::GET_REQUEST,
        'path' => '/signup',
        'controller' => '\App\Controller\Auth\Signup',
        'action' => 'showForm'
    ],
];
