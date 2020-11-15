<?php

namespace App\Model\User;

use App\Api\User\BackgroundPhotoInterface;
use Core\ActiveRecord\Model;
use App\Api\User\UserInterface;

/**
 * Class BackgroundPhoto
 * @package App\Model\User
 */
class BackgroundPhoto extends Model implements BackgroundPhotoInterface
{
    /**
     * @var string
     */
    protected $table = 'background_photos';

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
