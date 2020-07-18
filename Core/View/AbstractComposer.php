<?php

namespace Core\View;

/**
 * Class AbstractComposer
 * @package Core\View
 */
abstract class AbstractComposer
{
    /**
     * Add data for specific view
     *
     * @param \Core\Api\View\ViewInterface $view
     * @return \Core\Api\View\ViewInterface
     */
    abstract public function compose(\Core\Api\View\ViewInterface $view): object;
}
