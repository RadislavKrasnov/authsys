<?php

namespace App\Controller\Auth;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Controllers\Controller;
use App\Controller\Auth\Index;

/**
 * Class Signup
 * @package App\Controller\Auth
 */
class Signup extends Controller
{
    /**
     * Show form for sign up
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function showForm(RequestInterface $request, ResponseInterface $response)
    {
        $this->view('auth/signup.php', [], Index::AUTH_TEMPLATE);
    }
}
