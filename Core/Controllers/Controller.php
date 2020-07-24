<?php

namespace Core\Controllers;

use Core\Api\View\ViewInterface;

/**
 * Class Controller
 * @package Core\Controllers
 */
class Controller
{
    /**
     * @var ViewInterface
     */
    private $view;

    /**
     * Controller constructor.
     *
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view)
    {
        $this->view = $view;
    }

    /**
     * Render template and specific view
     *
     * @param string $view
     * @param array $data
     * @param string $template
     * @return void
     */
    public function view(string $view, array $data = [], string $template = ViewInterface::DEFAULT_TEMPLATE): void
    {
        $this->view->render($view, $data, $template);
    }
}
