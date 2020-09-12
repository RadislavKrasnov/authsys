<?php

namespace Core\Cookie;

use Core\Api\Cookie\CookieInterface;

/**
 * Class Cookie
 * @package Core\Cookie
 */
class Cookie implements CookieInterface
{
    /**
     * Set cookie value
     *
     * @param string $name
     * @param mixed $value
     * @param int $expires
     * @return void
     */
    public function setCookie(string $name, $value, int $expires = 0): void
    {
        setcookie($name, $value, $expires);
    }

    /**
     * Get cookie value
     *
     * @param string $name
     * @return mixed|null
     */
    public function getCookie(string $name)
    {
        if (!array_key_exists($name, $_COOKIE)) {
            return null;
        }

        return $_COOKIE[$name];
    }

    /**
     * Clear cookie
     *
     * @param string $name
     * @return void
     */
    public function clearCookie(string $name): void
    {
        $this->setCookie($name, '', time() - 3600);
    }
}
