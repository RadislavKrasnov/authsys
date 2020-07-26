<?php

namespace App\Model\Geo;

use Core\ActiveRecord\Model;
use App\Api\Geo\CountryInterface;

/**
 * Class Country
 * @package App\Model\Geo
 */
class Country extends Model implements CountryInterface
{
    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'code'
    ];

    /**
     * @return \Core\ActiveRecord\Collection
     */
    public function getRegions()
    {
        return $this->hasMany(\App\Api\Geo\RegionInterface::class, 'id', 'country_id');
    }

    /**
     * @return \Core\ActiveRecord\Collection
     */
    public function getCities()
    {
        return $this->hasMany(\App\Api\Geo\CityInterface::class, 'id', 'country_id');
    }
}
