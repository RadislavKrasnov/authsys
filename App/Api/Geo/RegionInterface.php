<?php

namespace App\Api\Geo;

/**
 * Interface RegionInterface
 * @package App\Api\Geo
 */
interface RegionInterface
{
    /**
     * @return \Core\ActiveRecord\Collection
     */
    public function getCities();

    /**
     * @return \App\Api\Geo\CountryInterface
     */
    public function getCountry();
}
