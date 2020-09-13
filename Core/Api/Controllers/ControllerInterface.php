<?php

namespace Core\Api\Controllers;

use Core\Api\View\ViewInterface;

/**
 * Interface ControllerInterface
 * @package Core\Api\Controllers
 */
interface ControllerInterface
{
    /**
     * Render template and specific view
     *
     * @param string $view
     * @param array $data
     * @param string $template
     * @return void
     */
    public function view(
        string $view,
        array $data = [],
        string $template =
        ViewInterface::DEFAULT_TEMPLATE
    ): void;
}
