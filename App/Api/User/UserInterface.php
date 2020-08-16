<?php

namespace App\Api\User;

use App\Api\Geo\CityInterface;
use App\Api\Geo\RegionInterface;
use App\Api\Geo\CountryInterface;

/**
 * Interface UserInterface
 * @package App\Api\User
 */
interface UserInterface
{
    /**
     * Get user by email
     *
     * @param string $email
     * @return UserInterface|null
     */
    public function getUserByEmail(string $email): ?object;

    /**
     * Get related city
     *
     * @return CityInterface
     */
    public function getCity();

    /**
     * Get related region
     *
     * @return RegionInterface
     */
    public function getRegion();

    /**
     * Get related country
     *
     * @return CountryInterface
     */
    public function getCountry();
}
