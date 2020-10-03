<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Authorization\AuthorizeInterface;
use App\Api\Geo\CountryInterface;
use App\Api\Geo\RegionInterface;
use App\Api\Geo\CityInterface;

/**
 * Class Form
 * @package App\Controller\Settings
 */
class Form extends Controller
{
    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * @var RegionInterface
     */
    private $region;

    /**
     * @var CityInterface
     */
    private $city;

    /**
     * Form constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param AuthorizeInterface $authorize
     * @param CountryInterface $country
     * @param RegionInterface $region
     * @param CityInterface $city
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize,
        CountryInterface $country,
        RegionInterface $region,
        CityInterface $city
    ) {
        $this->city = $city;
        $this->region = $region;
        $this->country = $country;
        $this->authorize = $authorize;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Settings form
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function showForm(RequestInterface $request, ResponseInterface $response): void
    {
        $this->isAuthorized();
        $user = $this->authorize->getLoggedInUser();
        $countries = $this->country->getAll();
        $regions = $this->region->select()->where([['country_id', '=', $user->countryId]])->get();
        $cities = $this->city->select()
            ->where([
                ['country_id', '=', $user->countryId],
                ['region_id', '=', $user->regionId]
            ])->get();

        $this->view('profile/settings.php',
            [
                'user' => $user,
                'countries' => $countries,
                'regions' => $regions,
                'cities' => $cities
            ],
            ViewInterface::DEFAULT_TEMPLATE
        );
    }

    /**
     * Check if user authorized and redirects to account page
     *
     * @return void
     */
    private function isAuthorized(): void
    {
        $isAuthorized = $this->authorize->isAuthorized();

        if (!$isAuthorized) {
            $this->redirect->redirect('/');
        }
    }
}
