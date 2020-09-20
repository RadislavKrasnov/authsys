<?php

namespace App\Controller\Auth;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Authorization\AuthorizeInterface;

/**
 * Class Logout
 * @package App\Controller\Index
 */
class Logout extends Controller
{
    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * Logout constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param AuthorizeInterface $authorize
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize
    ) {
        $this->authorize = $authorize;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Logout
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function logout(RequestInterface $request, ResponseInterface $response): void
    {
        $this->isAuthorized();

        if (!empty($this->session->getData('user_id'))) {
            $this->session->addData('user_id', '');
        }

        $this->session->destroy();
        $this->authorize->clearAuthCookie();
    }

    /**
     * Check if user authorized and redirects to account page
     *
     * @return void
     */
    private function isAuthorized(): void
    {
        $isAuthorized = $this->authorize->isAuthorized();

        if (!$isAuthorized) {
            $this->redirect->redirect('/');
        }
    }
}
