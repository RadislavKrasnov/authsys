<?php

namespace App\Controller\Auth;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Validation\ValidatorInterface;
use Core\Api\Messages\MessageManagerInterface;
use App\Api\User\UserInterface;
use App\Api\Authorization\AuthorizeInterface;

/**
 * Class Signin
 * @package App\Controller\Auth
 */
class Signin extends Controller
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
     * @var UserInterface
     */
    private $user;

    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * Signin constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param ValidatorInterface $validator
     * @param MessageManagerInterface $messageManager
     * @param UserInterface $user
     * @param AuthorizeInterface $authorize
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager,
        UserInterface $user,
        AuthorizeInterface $authorize
    ) {
        $this->authorize = $authorize;
        $this->user = $user;
        $this->messageManager = $messageManager;
        $this->validator = $validator;
        parent::__construct(
            $view,
            $session,
            $redirect
        );
    }

    /**
     * User sign in
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function signIn(RequestInterface $request, ResponseInterface $response)
    {
        $currentTime = time();
        $data = $request->getPostValues();

        if (empty($data['submit'])) {
            $this->redirect->redirect('/');
        }

        $this->validate($data);
        $isAuthenticated = false;
        $email = htmlspecialchars($data['email']);
        $password = htmlspecialchars($data['password']);
        $user = $this->user->getUserByEmail($email);

        if (empty($user)) {
            $this->messageManager->addMessage('You have provided wrong email or password');
            $this->redirect->redirect('/');
        }

        if (password_verify($password, $user->password)) {
            $isAuthenticated = true;
        }

        if (!$isAuthenticated) {
            $this->messageManager->addMessage('You have provided wrong email or password');
            $this->redirect->redirect('/');
        }

        $this->session->addData('user_id', $user->id);

        if (array_key_exists('remember', $data) && isset($data['remember'])) {
            $this->authorize->setRememberMeCookies($currentTime, $user);
        } else {
            $this->authorize->clearAuthCookie();
        }

        $this->redirect->redirect('/index');
    }

    /**
     * Validate sign in request
     *
     * @param array $data
     * @return void
     */
    private function validate(array $data): void
    {
        $rules = [
            'email' => ['required', 'email'],
            'password'  => ['required', 'password'],
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
            $this->redirect->redirect('/');
        }
    }
}
