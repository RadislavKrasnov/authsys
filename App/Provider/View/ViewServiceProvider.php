<?php

namespace App\Provider\View;

use Core\View\AbstractViewServiceProvider;

/**
 * Class ViewServiceProvider
 * @package App\Provider
 */
class ViewServiceProvider extends AbstractViewServiceProvider
{
    /**
     * Boot composer to the view
     *
     * @param \Core\Api\View\ViewInterface $view
     * @return \Core\Api\View\ViewInterface
     */
    public function boot(\Core\Api\View\ViewInterface $view): object
    {
        return $view;
    }
}
