<?php

namespace App\Model\Geo;

use Core\ActiveRecord\Model;
use App\Api\Geo\CityInterface;

/**
 * Class City
 * @package App\Model\Geo
 */
class City extends Model implements CityInterface
{
    /**
     * @var string
     */
    protected $table = 'cities';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'code',
        'country_id',
        'region_id',
        'latitude',
        'longitude'
    ];

    /**
     * @return \App\Api\Geo\CountryInterface
     */
    public function getCountry()
    {
        return $this->hasOne(\App\Api\Geo\CountryInterface::class, 'country_id', 'id');
    }

    /**
     * @return \App\Api\Geo\RegionInterface
     */
    public function getRegion()
    {
        return $this->hasOne(\App\Api\Geo\RegionInterface::class, 'region_id', 'id');
    }
}
