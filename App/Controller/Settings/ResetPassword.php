<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Validation\ValidatorInterface;
use Core\Api\Messages\MessageManagerInterface;
use App\Api\Authorization\AuthorizeInterface;
use Core\Api\Psr\Log\LoggerInterface;
use App\Api\User\UserInterface;

/**
 * Class ResetPassword
 * @package App\Controller\Settings
 */
class ResetPassword extends Controller
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ResetPassword constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param ValidatorInterface $validator
     * @param MessageManagerInterface $messageManager
     * @param AuthorizeInterface $authorize
     * @param LoggerInterface $logger
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager,
        AuthorizeInterface $authorize,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->authorize = $authorize;
        $this->messageManager = $messageManager;
        $this->validator = $validator;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Reset password
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function resetPassword(RequestInterface $request, ResponseInterface $response): void
    {
        $this->isAuthorized();
        $data = $request->getPostValues();

        $rules = [
            'current-password'  => ['required', 'password'],
            'password'  => ['required', 'password'],
            'confirmation-password' => ['required', 'password'],
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

        $currentPassword = htmlspecialchars($data['current-password']);
        $password = htmlspecialchars($data['password']);
        $confirmationPassword = htmlspecialchars($data['confirmation-password']);
        $user = $this->authorize->getLoggedInUser();

        if (!password_verify($currentPassword, $user->password)) {
            $this->messageManager->addMessage('You have input current password incorrectly');
            $this->redirect->redirect('/auth/account/settings');
        }

        if ($password !== $confirmationPassword) {
            $this->messageManager->addMessage('Password and confirmation password don\'t match');
            $this->redirect->redirect('/auth/account/settings');
        }

        $this->changePasswordInDd($data, $user);
    }

    /**
     * Update password in database
     *
     * @param array $data
     * @param UserInterface $user
     * @return void
     */
    private function changePasswordInDd(array $data, UserInterface $user): void
    {
        try {
            $user->password = password_hash(htmlspecialchars($data['password']), PASSWORD_BCRYPT);
            $user->save();
            $this->messageManager->addSuccessMessage('Password has been changed successfully');
            $this->redirect->redirect('/auth/account/settings');
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
}
