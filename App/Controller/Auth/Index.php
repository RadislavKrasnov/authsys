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

    /**
     * Show form for sign in
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->view('auth/signin.php', [], self::AUTH_TEMPLATE);
    }
}
