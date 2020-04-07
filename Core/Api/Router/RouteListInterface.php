<?php

namespace Core\Api\Router;

/**
 * Interface RouteList
 * @package Core\Api\Router
 */
interface RouteListInterface
{
    const ROUTES_FILE = '../router/routes.php';

    /**
     * Get routes from file
     *
     * @return array
     * @throws \Exception
     */
    public function getRoutes(): array;
}
