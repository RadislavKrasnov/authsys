<?php

namespace App\Api\Authorization;

use App\Api\User\UserInterface;

/**
 * Interface AuthorizeInterface
 * @package App\Api\Authorization
 */
interface AuthorizeInterface
{
    /**
     * Is user authorized
     *
     * @return bool
     */
    public function isAuthorized(): bool;

    /**
     * Set Remember me cookies
     *
     * @param int $currentTime
     * @param UserInterface $user
     * @return void
     */
    public function setRememberMeCookies(int $currentTime, UserInterface $user): void;

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
        string $currentDate
    ): bool;

    /**
     * Clear authentication cookies
     *
     * @return void
     */
    public function clearAuthCookie(): void;
}
