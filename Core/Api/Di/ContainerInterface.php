<?php

namespace Core\Api\Di;

/**
 * Interface ContainerInterface
 * @package Core\Api\Di
 */
interface ContainerInterface
{
    /**
     * Check if definition exists
     *
     * @param string $id
     * @return bool
     */
    public function has($id);

    /**
     * Get definition
     *
     * @param string $id
     * @return object
     */
    public function get($id);
}
