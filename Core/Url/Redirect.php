<?php

namespace Core\Url;

use Core\Api\Url\RedirectInterface;

/**
 * Class Redirect
 * @package Core\Url
 */
class Redirect implements RedirectInterface
{
    /**
     * Redirect to specified Url
     *
     * @param string $path
     * @return void
     */
    public function redirect(string $path): void
    {
        header('Location: ' . $path);
        die();
    }
}
