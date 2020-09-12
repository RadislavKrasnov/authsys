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
use Core\Api\Cookie\CookieInterface;
use App\Api\Authtoken\AuthtokenInterface;
use App\Api\Authtoken\TokenGeneratorInterface;
use Core\Api\Psr\Log\LoggerInterface;
use App\Api\User\UserInterface;

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
     * @var CookieInterface
     */
    private $cookie;

    /**
     * @var AuthtokenInterface
     */
    private $authtoken;

    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * Signin constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param ValidatorInterface $validator
     * @param MessageManagerInterface $messageManager
     * @param CookieInterface $cookie
     * @param AuthtokenInterface $authtoken
     * @param TokenGeneratorInterface $tokenGenerator
     * @param LoggerInterface $logger
     * @param UserInterface $user
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager,
        CookieInterface $cookie,
        AuthtokenInterface $authtoken,
        TokenGeneratorInterface $tokenGenerator,
        LoggerInterface $logger,
        UserInterface $user
    ) {
        $this->user = $user;
        $this->logger = $logger;
        $this->authtoken = $authtoken;
        $this->tokenGenerator = $tokenGenerator;
        $this->cookie = $cookie;
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
        $currentTime = time();
        $currentDate = date('Y-m-d H:i:s', $currentTime);
        $userEmail = $this->cookie->getCookie('email');
        $randomPassword = $this->cookie->getCookie('random_password');
        $randomSelector = $this->cookie->getCookie('random_selector');
        $isLoggedIn = false;

        if (!empty($this->session->getData('user_id'))) {
            $isLoggedIn = true;
        } else if (!empty($userEmail) && !empty($randomPassword) && !empty($randomSelector)) {
            $isLoggedIn = $this->isLoggedInWithRememberMe(
                $userEmail,
                $randomPassword,
                $randomSelector,
                $currentDate
            );
        }

        if ($isLoggedIn) {
            $this->redirect->redirect('/index');
        }

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
            $this->setRememberMeCookies($currentTime, $user);
        } else {
            $this->clearAuthCookie();
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

    /**
     * Check if remember me session is logged in
     *
     * @param string $userEmail
     * @param string $randomPassword
     * @param string $randomSelector
     * @param string $currentDate
     * @return bool
     */
    private function isLoggedInWithRememberMe(
        string $userEmail,
        string $randomPassword,
        string $randomSelector,
        string $currentDate
    ) {
        $isPasswordVerified = false;
        $isSelectorVerified = false;
        $isExpiredDateVerified = false;

        if (empty($userEmail)) {
            return false;
        }

        $token = $this->authtoken->getTokenByEmail($userEmail, 0);

        if (empty($token)) {
            return false;
        }

        if (password_verify($randomPassword, $token->passwordHash)) {
            $isPasswordVerified = true;
        }

        if (password_verify($randomSelector, $token->selectorHash)) {
            $isSelectorVerified = true;
        }

        if ($token->exiryDate >= $currentDate) {
            $isExpiredDateVerified = true;
        }

        if ($isPasswordVerified && $isSelectorVerified && $isExpiredDateVerified) {
            return true;
        } else {
            try {
                $token->isExpired = 1;
                $token->save();
                $this->clearAuthCookie();
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * Clear authentication cookies
     *
     * @return void
     */
    private function clearAuthCookie(): void
    {
        $this->cookie->clearCookie('email');
        $this->cookie->clearCookie('random_password');
        $this->cookie->clearCookie('random_selector');
    }

    /**
     * Set Remember me cookies
     *
     * @param int $currentTime
     * @param UserInterface $user
     * @throws \Exception
     */
    private function setRememberMeCookies(int $currentTime, UserInterface $user): void
    {
        try {
            $cookieExpirationTime = $currentTime + (30 * 24 * 60 * 60);

            $this->cookie->setCookie('email', $user->email, $cookieExpirationTime);

            $randomPassword = $this->tokenGenerator->generateToken(16);
            $this->cookie->setCookie('random_password', $randomPassword, $cookieExpirationTime);

            $randomSelector = $this->tokenGenerator->generateToken(32);
            $this->cookie->setCookie('random_selector', $randomSelector, $cookieExpirationTime);

            $randomPasswordHash = password_hash($randomPassword, PASSWORD_DEFAULT);
            $randomSelectorHash = password_hash($randomSelector, PASSWORD_DEFAULT);
            $expiryDate = date('Y-m-d H:i:s', $cookieExpirationTime);

            $token = $this->authtoken->getTokenByEmail($user->email, 0);

            if (!empty($token)) {
                $token->isExpired = 1;
                $token->save();
            }

            $newToken = $this->authtoken->newInstance([
                'email' => $user->email,
                'password_hash' => $randomPasswordHash,
                'selector_hash' => $randomSelectorHash,
                'expiry_date' => $expiryDate
            ]);
            $newToken->save();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
