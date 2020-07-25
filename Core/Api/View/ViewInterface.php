<?php

namespace Core\Api\View;

/**
 * Interface ViewInterface
 * @package Core\Api\View
 */
interface ViewInterface
{
    const TEMPLATE_PATH = '../App/view/templates/';
    const DEFAULT_TEMPLATE = 'main.php';
    const DEFAULT_HEAD_FILES_PATH = '../App/view/templates/head/';

    /**
     * Render view
     *
     * @param string $view
     * @param array $data
     * @param string $template
     * @return void
     */
    public function render(string $view, array $data = [], string $template = self::DEFAULT_TEMPLATE): void;

    /**
     * Show template
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function show(string $view, array $data = []): void;

    /**
     * Get view name
     *
     * @return string
     */
    public function getViewName(): string;

    /**
     * Get view data
     *
     * @return array
     */
    public function getData(): array;

    /**
     * Set view data
     *
     * @param array $data
     * @return ViewInterface
     */
    public function setData(array $data): object;

    /**
     * Add view data
     *
     * @param array $data
     * @return ViewInterface
     */
    public function addData(array $data): object;

    /**
     * Get template name
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Add data to view for whole template
     *
     * @param string $view
     * @param string $composer
     * @return ViewInterface
     */
    public function composer(string $view, string $composer): object;

    /**
     * Set head html tag for view
     *
     * @param string $view
     * @return void
     */
    public function head(string $view): void;
}
