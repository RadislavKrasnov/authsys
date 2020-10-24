<?php

namespace App\Model\User;

use App\Api\User\AvatarInterface;
use Core\ActiveRecord\Model;
use App\Api\User\UserInterface;

/**
 * Class Avatar
 * @package App\Model\User
 */
class Avatar extends Model implements AvatarInterface
{
    /**
     * @var string
     */
    protected $table = 'avatars';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = ['id', 'path', 'user_id'];

    /**
     * Get user
     *
     * @return UserInterface|bool
     */
    public function getUser()
    {
        return $this->hasOne(UserInterface::class, 'user_id', 'id');
    }
}
