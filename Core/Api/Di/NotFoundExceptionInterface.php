<?php

namespace Core\Api\Di;

/**
 * Interface NotFoundExceptionInterface
 * @package Core\Api\Di
 */
interface NotFoundExceptionInterface
{
    /**
     * Create exception
     *
     * @param string $id
     * @return mixed
     */
    public static function create($id);
}
