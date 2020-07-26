<?php

namespace App\Model\Geo;

use Core\ActiveRecord\Model;
use App\Api\Geo\RegionInterface;

/**
 * Class Region
 * @package App\Model\Geo
 */
class Region extends Model implements RegionInterface
{
    /**
     * @var string
     */
    protected $table = 'regions';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'code', 'country_id'
    ];

    /**
     * @return \App\Api\Geo\CountryInterface
     */
    public function getCountry()
    {
        return $this->hasOne(\App\Api\Geo\CountryInterface::class, 'country_id', 'id');
    }

    /**
     * @return \Core\ActiveRecord\Collection
     */
    public function getCities()
    {
        return $this->hasMany(\App\Api\Geo\CityInterface::class, 'id', 'region_id');
    }
}
