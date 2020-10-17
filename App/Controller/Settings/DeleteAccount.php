<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Authorization\AuthorizeInterface;

/**
 * Class DeleteAccount
 * @package App\Controller\Settings
 */
class DeleteAccount extends Controller
{
    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize
    ) {
        $this->authorize = $authorize;
        parent::__construct($view, $session, $redirect);
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        $this->isAuthorized();

        $user = $this->authorize->getLoggedInUser();
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
