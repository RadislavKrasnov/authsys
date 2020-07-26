<?php

namespace App\Api\Geo;

/**
 * Interface CityInterface
 * @package App\Api\Geo
 */
interface CityInterface
{
    /**
     * @return \App\Api\Geo\RegionInterface
     */
    public function getRegion();

    /**
     * @return \App\Api\Geo\CountryInterface
     */
    public function getCountry();
}
