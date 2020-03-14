<?php

namespace Core\Api\Di;

/**
 * Interface DiManagerInterface
 * @package Core\Api\Di
 */
interface DiManagerInterface
{
    /**
     * @return \Core\Api\Di\ContainerInterface
     */
    public function getContainer(): object;
}
