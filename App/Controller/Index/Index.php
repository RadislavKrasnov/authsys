<?php

namespace App\Controller\Index;

use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;

/**
 * Class Index
 * @package App\Controller\Index
 */
class Index extends Controller
{
    /**
     * Main page
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->isAuthorized();

        echo "Index page";
    }
}
