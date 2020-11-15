<?php

namespace App\Api\User;

use App\Api\User\UserInterface;

/**
 * Interface BackgroundPhotoInterface
 * @package App\Api\User
 */
interface BackgroundPhotoInterface
{
    /**
     * Get user
     *
     * @return UserInterface|bool
     */
    public function getUser();
}
