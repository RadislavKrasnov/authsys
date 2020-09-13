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
use Core\Api\Psr\Log\LoggerInterface;

/**
 * Class CreateAccount
 * @package App\Controller\Auth
 */
class CreateAccount extends Controller
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * CreateAccount constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param LoggerInterface $logger
     * @param ValidatorInterface $validator
     * @param MessageManagerInterface $messageManager
     * @param UserInterface $user
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        LoggerInterface $logger,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager,
        UserInterface $user
    ) {
        $this->logger = $logger;
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
     * Create an account
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function create(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getPostValues();

        if (empty($data['submit'])) {
            $this->redirect->redirect('/');
        }

        $rules = [
            'first-name' => ['required', 'alphanumeric'],
            'last-name' => ['required', 'alphanumeric'],
            'email' => ['required', 'email'],
            'password'  => ['required', 'password'],
            'confirmation-password' => ['required', 'password'],
            'birth-date' => ['required', 'usa_date_format'],
            'country' => ['required', 'numeric'],
            'region' => ['numeric'],
            'city' => ['required', 'numeric'],
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
            $this->redirect->redirect('/signup');
        }

        $email = htmlspecialchars($data['email']);

        $user = $this->user->getUserByEmail($email);

        if (!empty($user)) {
            $this->messageManager->addMessage('This email is already used');
            $this->redirect->redirect('/signup');
        }

        $password = htmlspecialchars($data['password']);
        $confirmationPassword = htmlspecialchars($data['confirmation-password']);

        if ($password !== $confirmationPassword) {
            $this->messageManager->addMessage('Password and confirmation password don\'t match');
            $this->redirect->redirect('/signup');
        }

        $this->createUser($data);
        $this->redirect->redirect('/index');
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return void
     */
    private function createUser($data): void
    {
        $user = $this->user->newInstance();
        $user->password = password_hash(htmlspecialchars($data['password']), PASSWORD_BCRYPT);
        $user->firstName = htmlspecialchars($data['first-name']);
        $user->lastName = htmlspecialchars($data['last-name']);
        $user->email = htmlspecialchars($data['email']);
        $user->birthDate = htmlspecialchars($data['birth-date']);
        $user->countryId = htmlspecialchars($data['country']);
        $user->cityId = htmlspecialchars($data['city']);

        if (array_key_exists('region', $data) && !empty($data['region'])) {
            $user->regionId = htmlspecialchars($data['region']);
        }

        try {
            $user->save();
            $id = $user->getLastInsertId();
            $this->session->addData('user_id', $id);
        } catch (\Exception $exception) {
            $this->messageManager->addMessage($exception->getMessage());
            $this->logger->error($exception->getMessage());
            $this->redirect->redirect('/signup');
        }
    }
}
