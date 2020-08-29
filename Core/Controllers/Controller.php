<?php

namespace Core\Controllers;

use Core\Api\View\ViewInterface;
use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;

/**
 * Class Controller
 * @package Core\Controllers
 */
class Controller
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var RedirectInterface
     */
    protected $redirect;

    /**
     * Controller constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect
    ) {
        $this->redirect = $redirect;
        $this->session = $session;
        $this->view = $view;
    }

    /**
     * Render template and specific view
     *
     * @param string $view
     * @param array $data
     * @param string $template
     * @return void
     */
    public function view(string $view, array $data = [], string $template = ViewInterface::DEFAULT_TEMPLATE): void
    {
        $this->view->render($view, $data, $template);
    }

    /**
     * Is user authorized
     *
     * @return void
     */
    public function isAuthorized()
    {
        $userId = $this->session->getData('user_id');

        if (empty($userId)) {
            $this->redirect->redirect('/');
        }
    }
}
