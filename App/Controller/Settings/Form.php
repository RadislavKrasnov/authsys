<?php

namespace App\Controller\Settings;

use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;

/**
 * Class Form
 * @package App\Controller\Settings
 */
class Form extends Controller
{
    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function showForm(RequestInterface $request, ResponseInterface $response): void
    {
        $this->view('profile/settings.php', [], ViewInterface::DEFAULT_TEMPLATE);
    }
}
