<?php

namespace App\Api\User;

use App\Api\User\UserInterface;

/**
 * Interface AvatarInterface
 * @package App\Api\User
 */
interface AvatarInterface
{
    /**
     * Get user
     *
     * @return UserInterface|bool
     */
    public function getUser();
}
