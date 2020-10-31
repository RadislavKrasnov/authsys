<?php

namespace App\Controller\Index;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Messages\MessageManagerInterface;
use App\Api\Authorization\AuthorizeInterface;

/**
 * Class Index
 * @package App\Controller\Index
 */
class Index extends Controller
{
    /**
     * Avatar placeholder image path
     */
    const AVATAR_PLACEHOLDER_PATH = '/media/profile/placeholders/avatar_placeholder.png';

    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * Index constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param AuthorizeInterface $authorize
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize,
        MessageManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
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
        $user = $this->authorize->getLoggedInUser();
        $messages = $this->messageManager->getMessages(true);
        $successMessages = $this->messageManager->getSuccessMessages(true);
        $avatarPath = (!empty($user->getAvatar())) ? $user->getAvatar()->path : self::AVATAR_PLACEHOLDER_PATH;

        $this->view(
            'profile/index.php',
            [
                'user' => $user,
                'avatarPath' => $avatarPath,
                'messages' => $messages,
                'successMessages' => $successMessages
            ],
            ViewInterface::DEFAULT_TEMPLATE
        );
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
