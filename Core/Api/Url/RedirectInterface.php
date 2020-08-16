<?php

namespace Core\Api\Url;

/**
 * Interface RedirectInterface
 * @package Core\Api\Url
 */
interface RedirectInterface
{
    /**
     * Redirect to specified Url
     *
     * @param string $path
     * @return void
     */
    public function redirect(string $path): void;
}
