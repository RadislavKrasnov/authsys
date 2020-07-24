<?php

namespace App\Controller\Auth;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Controllers\Controller;

/**
 * Class Index
 * @package App\Auth
 */
class Index extends Controller
{
    const AUTH_TEMPLATE = 'auth/auth.php';

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->view('auth/signin.php', [], self::AUTH_TEMPLATE);
    }
}
