<?php

namespace Core\Session;

use Core\Api\Session\SessionInterface;

/**
 * Class Session
 * @package Core\Session
 */
class Session implements SessionInterface
{
    /**
     * Start session
     *
     * @return void
     */
    public function start(): void
    {
        session_start();
    }

    /**
     * Destroy session
     *
     * @return void
     */
    public function destroy(): void
    {
        session_destroy();
    }

    /**
     * Add data into session
     *
     * @param string $name
     * @param mixed $value
     * @return SessionInterface
     */
    public function addData(string $name, $value): object
    {
        $_SESSION[$name] = $value;

        return $this;
    }

    /**
     * Get data from session
     *
     * @param string $name
     * @return mixed|null
     */
    public function getData(string $name)
    {
        if (!array_key_exists($name, $_SESSION)) {
            return null;
        }

        return $_SESSION[$name];
    }
}
