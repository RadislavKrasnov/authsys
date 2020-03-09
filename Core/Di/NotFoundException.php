<?php

namespace Core\Di;

use Core\Api\Di\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 * @package Core\Di
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
    /**
     * Create exception
     *
     * @param string $id
     * @return NotFoundException|mixed
     */
    public static function create($id)
    {
        return new self(sprintf('No container definition was found for "%s"', $id));
    }
}
