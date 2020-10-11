<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Authorization\AuthorizeInterface;
use Core\Api\Validation\ValidatorInterface;
use Core\Api\Messages\MessageManagerInterface;
use Core\Api\Psr\Log\LoggerInterface;

/**
 * Class ChangeEmail
 * @package App\Controller\Settings
 */
class ChangeEmail extends Controller
{
    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ChangeEmail constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param AuthorizeInterface $authorize
     * @param ValidatorInterface $validator
     * @param MessageManagerInterface $messageManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->messageManager = $messageManager;
        $this->validator = $validator;
        $this->authorize = $authorize;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Change email
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function changeEmail(RequestInterface $request, ResponseInterface $response): void
    {
        $this->isAuthorized();
        $data = $request->getPostValues();

        $rules = [
            'email' => ['required', 'email'],
        ];

        $this->validator->validate($data, $rules);
        $errors = $this->validator->errors();

        if (!empty($errors)) {
            $messages = [];

            foreach ($errors as $error) {
                foreach ($error as $message) {
                    $messages[] = $message;
                }
            }

            $this->messageManager->addMessages($messages);
            $this->redirect->redirect('/auth/account/settings');
        }

        try {
            $email = htmlspecialchars($data['email']);
            $user = $this->authorize->getLoggedInUser();
            $user->email = $email;
            $user->save();
            $this->logout();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }
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

    /**
     * Logout
     *
     * @return void
     */
    private function logout(): void
    {
        if (!empty($this->session->getData('user_id'))) {
            $this->session->addData('user_id', '');
        }

        $this->session->destroy();
        $this->authorize->clearAuthCookie();
        $this->redirect->redirect('/');
    }
}
