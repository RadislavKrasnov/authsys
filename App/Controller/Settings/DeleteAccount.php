<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Authorization\AuthorizeInterface;
use App\Controller\Auth\Logout;

/**
 * Class DeleteAccount
 * @package App\Controller\Settings
 */
class DeleteAccount extends Controller
{
    /**
     * Authorize
     *
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * Logout Controller
     *
     * @var Logout
     */
    private $logout;

    /**
     * DeleteAccount constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param AuthorizeInterface $authorize
     * @param Logout $logout
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize,
        Logout $logout
    ) {
        $this->logout = $logout;
        $this->authorize = $authorize;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Delete account
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        $this->isAuthorized();
        $user = $this->authorize->getLoggedInUser();
        $user->delete();
        $this->logout->logout($request, $response);
        $this->redirect->redirect('/');
    }

    /**
     * Check if user is authorized
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
