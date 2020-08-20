<?php

namespace App\Controller\Geo;

use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Geo\CountryInterface;

/**
 * Class Region
 * @package App\Controller\Auth
 */
class Region extends Controller
{
    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * Region constructor.
     *
     * @param ViewInterface $view
     * @param CountryInterface $country
     */
    public function __construct(
        ViewInterface $view,
        CountryInterface $country
    ) {
        $this->country = $country;
        parent::__construct($view);
    }

    /**
     * Get regions of selected country from auth form
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return string|null
     */
    public function getRegions(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getPostValues();

        if (!array_key_exists('country_id', $data)) {
            return null;
        }

        $countryId = $data['country_id'];
        $country = $this->country->select()->where([['id', '=', $countryId]])->first();
        $regions = $country->getRegions();
        $html = '';
        $firstRegion = $regions->offsetGet(0);
        $result = [];

        if (!empty($firstRegion)) {
            $result['firstRegionId'] = $firstRegion->id;
        }

        foreach ($regions as $region) {

            $name = $region->name;
            $id = $region->id;

            if (empty($name)) {
                continue;
            }

            $html .= "<option value=\"$id\">$name</option>";
        }

        $result['html'] = $html;

        return json_encode($result);
    }
}
