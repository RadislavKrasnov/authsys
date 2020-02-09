<?php

namespace Core\Api\Router;

use Core\Api\Router\RequestInterface;

interface RouteInterface
{
    public function createController();

    public function getAction();

    public function match(RequestInterface $request);
}
