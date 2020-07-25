<?php

namespace Core\View;

use Core\Api\View\ViewInterface;
use Core\Di\DiManager;
use Core\Api\View\ViewServiceProviderInterface;

/**
 * Class View
 * @package Core\View
 */
class View implements ViewInterface
{
    /**
     * View name
     *
     * @var string
     */
    private $view;

    /**
     * View data
     *
     * @var array
     */
    private $data;

    /**
     * Main template
     *
     * @var string
     */
    private $template;

    /**
     * DI manager
     *
     * @var DiManager
     */
    private $diManager;

    /**
     * View service provider
     *
     * @var ViewServiceProviderInterface
     */
    private $viewServiceProvider;

    /**
     * View constructor.
     *
     * @param DiManager $diManager
     * @param ViewServiceProviderInterface $viewServiceProvider
     */
    public function __construct(
        DiManager $diManager,
        ViewServiceProviderInterface $viewServiceProvider
    ) {
        $this->diManager = $diManager;
        $this->viewServiceProvider = $viewServiceProvider;
    }

    /**
     * Render main template with specific view
     *
     * @param string $view
     * @param array $data
     * @param string $template
     * @return void
     */
    public function render(string $view, array $data = [], string $template = self::DEFAULT_TEMPLATE): void
    {
        $this->template = self::TEMPLATE_PATH . $template;
        $this->setData($data);

        include $this->getTemplate();
    }

    /**
     * Show specific view in the template
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function show(string $view, array $data = []): void
    {
        $this->view = $view;
        $this->viewServiceProvider->boot($this);
        extract($this->getData());

        include self::TEMPLATE_PATH . $view;
    }

    /**
     * Get view name
     *
     * @return string
     */
    public function getViewName(): string
    {
        return $this->view;
    }

    /**
     * Get view data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set view data
     *
     * @param array $data
     * @return ViewInterface
     */
    public function setData(array $data): object
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Add view data
     *
     * @param array $data
     * @return ViewInterface
     */
    public function addData(array $data): object
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * Get template name
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Add data to view for whole template
     *
     * @param string $view
     * @param string $composer
     * @return ViewInterface
     */
    public function composer(string $view, string $composer): object
    {
        if ($this->getViewName() !== $view) {
            return $this;
        }

        $container = $this->diManager->getContainer();
        $composer = $container->get($composer);
        $view = $composer->compose($this);

        return $view;
    }

    /**
     * Set head html tag for view
     *
     * @param string $view
     * @return void
     */
    public function head(string $view): void
    {
        $headFile = self::DEFAULT_HEAD_FILES_PATH . $view;
        if (!file_exists($headFile)) {
            return;
        }

        include $headFile;
    }
}
