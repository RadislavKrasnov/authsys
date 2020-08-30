<?php

namespace App\Controller\Auth;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Messages\MessageManagerInterface;

/**
 * Class Index
 * @package App\Auth
 */
class Index extends Controller
{
    const AUTH_TEMPLATE = 'auth/auth.php';

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        MessageManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Show form for sign in
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $messages = $this->messageManager->getMessages(true);
        $this->view('auth/signin.php', ['messages' => $messages], self::AUTH_TEMPLATE);
    }
}
