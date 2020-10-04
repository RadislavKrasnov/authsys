<?php

namespace App\Model\Authorization;

use Core\Api\Cookie\CookieInterface;
use Core\Api\Session\SessionInterface;
use Core\Api\Psr\Log\LoggerInterface;
use App\Api\Authorization\AuthorizeInterface;
use App\Api\User\UserInterface;
use App\Api\Authtoken\AuthtokenInterface;
use App\Api\Authtoken\TokenGeneratorInterface;

/**
 * Class Authorize
 * @package App\Model\Authorization
 */
class Authorize implements AuthorizeInterface
{
    /**
     * @var CookieInterface
     */
    private $cookie;

    /**
     * @var SessionInterface
     */
    private $session;

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
     * Authorize constructor.
     *
     * @param CookieInterface $cookie
     * @param SessionInterface $session
     * @param AuthtokenInterface $authtoken
     * @param TokenGeneratorInterface $tokenGenerator
     * @param LoggerInterface $logger
     * @param UserInterface $user
     */
    public function __construct(
        CookieInterface $cookie,
        SessionInterface $session,
        AuthtokenInterface $authtoken,
        TokenGeneratorInterface $tokenGenerator,
        LoggerInterface $logger,
        UserInterface $user
    ) {
        $this->cookie = $cookie;
        $this->session = $session;
        $this->authtoken = $authtoken;
        $this->tokenGenerator = $tokenGenerator;
        $this->logger = $logger;
        $this->user = $user;
    }

    /**
     * Is user authorized
     *
     * @return bool
     */
    public function isAuthorized(): bool
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

        return $isLoggedIn;
    }

    /**
     * Set Remember me cookies
     *
     * @param int $currentTime
     * @param UserInterface $user
     * @return void
     */
    public function setRememberMeCookies(int $currentTime, UserInterface $user): void
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

    /**
     * Check if remember me session is logged in
     *
     * @param string $userEmail
     * @param string $randomPassword
     * @param string $randomSelector
     * @param string $currentDate
     * @return bool
     */
    public function isLoggedInWithRememberMe(
        string $userEmail,
        string $randomPassword,
        string $randomSelector,
        string $currentDate): bool {

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

        if ($token->expiryDate >= $currentDate) {
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

            return false;
        }
    }

    /**
     * Clear authentication cookies
     *
     * @return void
     */
    public function clearAuthCookie(): void
    {
        $this->cookie->clearCookie('email');
        $this->cookie->clearCookie('random_password');
        $this->cookie->clearCookie('random_selector');
    }

    /**
     * Get logged in user
     *
     * @return UserInterface|null
     */
    public function getLoggedInUser(): ?object
    {
        $user = null;

        try {
            if (!empty($this->session->getData('user_id'))) {
                $userId = $this->session->getData('user_id');
                $user = $this->user->find($userId);
            }

            if (!empty($this->cookie->getCookie('email'))) {
                $email = $this->cookie->getCookie('email');
                $user = $this->user->select()
                    ->where([['email', '=', $email]])
                    ->first();
            }
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $user;
    }
}
