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
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/regions',
        'controller' => '\App\Controller\Geo\Region',
        'action' => 'getRegions'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/cities',
        'controller' => '\App\Controller\Geo\City',
        'action' => 'getCities'
    ],
];
