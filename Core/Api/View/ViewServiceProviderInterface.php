<?php

namespace Core\Api\View;

/**
 * Class ViewServiceProviderInterface
 * @package Core\Api\View
 */
interface ViewServiceProviderInterface
{
    /**
     * Boot composer to the view
     *
     * @param \Core\Api\View\ViewInterface $view
     * @return \Core\Api\View\ViewInterface
     */
    public function boot(\Core\Api\View\ViewInterface $view): object;
}
