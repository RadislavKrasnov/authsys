<?php

namespace Core\View;

use Core\Api\View\ViewServiceProviderInterface;

/**
 * Class AbstractViewServiceProvider
 * @package Core\View
 */
abstract class AbstractViewServiceProvider implements ViewServiceProviderInterface
{
    /**
     * Boot composer to the view
     *
     * @param \Core\Api\View\ViewInterface $view
     * @return \Core\Api\View\ViewInterface
     */
    abstract public function boot(\Core\Api\View\ViewInterface $view): object;
}
