<?php

namespace App\Controller\Auth;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Messages\MessageManagerInterface;
use App\Controller\Auth\Index;
use App\Api\Geo\CountryInterface;

/**
 * Class Signup
 * @package App\Controller\Auth
 */
class Signup extends Controller
{
    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * Signup constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param CountryInterface $country
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        CountryInterface $country,
        MessageManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
        $this->country = $country;
        parent::__construct(
            $view,
            $session,
            $redirect
        );
    }

    /**
     * Show form for sign up
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function showForm(RequestInterface $request, ResponseInterface $response)
    {
        $countries = $this->country->getAll();
        $messages = $this->messageManager->getMessages(true);
        $this->view(
            'auth/signup.php',
            ['countries' => $countries, 'messages' => $messages],
            Index::AUTH_TEMPLATE
        );
    }
}
