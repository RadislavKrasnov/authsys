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
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/auth/account/create',
        'controller' => '\App\Controller\Auth\CreateAccount',
        'action' => 'create'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::GET_REQUEST,
        'path' => '/index',
        'controller' => '\App\Controller\Index\Index',
        'action' => 'index'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/auth/account/signin',
        'controller' => '\App\Controller\Auth\Signin',
        'action' => 'signIn'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/auth/account/logout',
        'controller' => '\App\Controller\Auth\Logout',
        'action' => 'logout'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::GET_REQUEST,
        'path' => '/auth/account/settings',
        'controller' => '\App\Controller\Settings\Form',
        'action' => 'showForm'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/auth/account/settings/save',
        'controller' => '\App\Controller\Settings\Save',
        'action' => 'save'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/auth/account/settings/password/reset',
        'controller' => '\App\Controller\Settings\ResetPassword',
        'action' => 'resetPassword'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/auth/account/settings/email/change',
        'controller' => '\App\Controller\Settings\ChangeEmail',
        'action' => 'changeEmail'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/user/avatar/upload',
        'controller' => '\App\Controller\User\Avatar\Uploader',
        'action' => 'upload'
    ],
    [
        'request_method' => \Core\Api\Router\RouterInterface::POST_REQUEST,
        'path' => '/user/background/upload',
        'controller' => '\App\Controller\User\Background\Uploader',
        'action' => 'upload'
    ],
];
