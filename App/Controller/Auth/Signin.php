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

    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
        $this->validator = $validator;
        parent::__construct($view, $session, $redirect);
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
        $data = $request->getPostValues();

        if (empty($data['submit'])) {
            $this->redirect->redirect('/');
        }

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

        echo 'Hello World';
    }
}
