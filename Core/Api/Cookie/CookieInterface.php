<?php

namespace Core\Api\Cookie;

/**
 * Interface CookieInterface
 * @package Core\Api\Cookie
 */
interface CookieInterface
{
    /**
     * Set cookie value
     *
     * @param string $name
     * @param mixed $value
     * @param int $expires
     * @return void
     */
    public function setCookie(string $name, $value, int $expires = 0): void;

    /**
     * Get cookie value
     *
     * @param string $name
     * @return mixed|null
     */
    public function getCookie(string $name);

    /**
     * Clear cookie
     *
     * @param string $name
     * @return void
     */
    public function clearCookie(string $name): void;
}
