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
//        $view->composer('test2.php', \App\Provider\View\TestComposer::class);
//        $view->composer('test3.php', \App\Provider\View\TestTwoComposer::class);

        return $view;
    }
}
