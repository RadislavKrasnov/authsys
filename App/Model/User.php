<?php

namespace App\Model;

use Core\ActiveRecord\Model;
use App\Api\User\UserInterface;
use App\Api\User\AvatarInterface;

/**
 * Class User
 * @package App\Model
 */
class User extends Model implements UserInterface
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'password',
        'email',
        'birth_date',
        'country_id',
        'region_id',
        'city_id'
    ];

    /**
     * Get user by email
     *
     * @param string $email
     * @return UserInterface|null
     */
    public function getUserByEmail(string $email): ?object
    {
        $user = $this->select()->where([['email', '=', $email]])->first();

        if (!$user) {
            return null;
        }

        return $user;
    }

    /**
     * Get related city
     *
     * @return \App\Api\Geo\CityInterface
     */
    public function getCity()
    {
       return $this->hasOne(\App\Api\Geo\CityInterface::class, 'city_id', 'id');
    }

    /**
     * Get related region
     *
     * @return \App\Api\Geo\RegionInterface
     */
    public function getRegion()
    {
        return $this->hasOne(\App\Api\Geo\RegionInterface::class, 'region_id', 'id');
    }

    /**
     * Get related country
     *
     * @return \App\Api\Geo\CountryInterface
     */
    public function getCountry()
    {
        return $this->hasOne(\App\Api\Geo\CountryInterface::class, 'country_id', 'id');
    }

    /**
     * Get user's avatar
     *
     * @return AvatarInterface|bool
     */
    public function getAvatar()
    {
        return $this->hasOne(AvatarInterface::class, 'id', 'user_id');
    }
}
