<?php

namespace App\Controller\Index;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Authorization\AuthorizeInterface;

/**
 * Class Index
 * @package App\Controller\Index
 */
class Index extends Controller
{
    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * Index constructor.
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
     * Main page
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->isAuthorized();

        $this->view('profile/index.php', [], ViewInterface::DEFAULT_TEMPLATE);
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
