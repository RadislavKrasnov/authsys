<?php

namespace Core\Api\Session;

/**
 * Interface SessionInterface
 * @package Core\Api\Session
 */
interface SessionInterface
{
    /**
     * Start session
     *
     * @return void
     */
    public function start(): void;

    /**
     * Destroy session
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Add data into session
     *
     * @param string $name
     * @param mixed $value
     * @return SessionInterface
     */
    public function addData(string $name, $value): object;

    /**
     * Get data from session
     *
     * @param string $name
     * @return mixed|null
     */
    public function getData(string $name);
}
