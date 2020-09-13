<?php

namespace App\Controller\Geo;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use App\Api\Geo\RegionInterface;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;

/**
 * Class City
 * @package App\Controller\Geo
 */
class City extends Controller
{
    /**
     * @var RegionInterface
     */
    private $region;

    /**
     * City constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param RegionInterface $region
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        RegionInterface $region
    ) {
        $this->region = $region;
        parent::__construct(
            $view,
            $session,
            $redirect
        );
    }

    /**
     * Get cities of selected region from auth form
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return string|null
     */
    public function getCities(RequestInterface $request, ResponseInterface $response)
    {
        $data = $request->getPostValues();

        if (!array_key_exists('region_id', $data)) {
            return null;
        }

        $regionId = $data['region_id'];
        $region = $this->region->select()->where([['id', '=', $regionId]])->first();
        $cities = $region->getCities();
        $html = '';

        foreach ($cities as $city) {
            $id = $city->id;
            $name = $city->name;

            $html .= "<option value=\"$id\">$name</option>";
        }

        return $html;
    }
}
