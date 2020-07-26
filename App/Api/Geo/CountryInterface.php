<?php

namespace App\Api\Geo;

/**
 * Interface CountryInterface
 * @package App\Api\Geo
 */
interface CountryInterface
{
    /**
     * @return \Core\ActiveRecord\Collection
     */
    public function getRegions();

    /**
     * @return \Core\ActiveRecord\Collection
     */
    public function getCities();
}
