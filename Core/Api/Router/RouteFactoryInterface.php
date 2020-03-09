<?php

namespace Core\Api\Router;

/**
 * Interface RouteFactoryInterface
 * @package Core\Api\Router
 */
interface RouteFactoryInterface
{
    /**
     * @return \Core\Api\Router\RouteFactoryInterface
     */
    public function create(): object ;
}
