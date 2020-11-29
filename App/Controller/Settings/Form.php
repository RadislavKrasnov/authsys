<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Messages\MessageManagerInterface;
use App\Api\Authorization\AuthorizeInterface;
use App\Api\Geo\CountryInterface;
use App\Api\Geo\RegionInterface;
use App\Api\Geo\CityInterface;
use App\Controller\Index\Index;
use App\Api\Image\ImageOptimizerInterface;

/**
 * Class Form
 * @package App\Controller\Settings
 */
class Form extends Controller
{
    /**
     * Authorize
     *
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * Country
     *
     * @var CountryInterface
     */
    private $country;

    /**
     * Region
     *
     * @var RegionInterface
     */
    private $region;

    /**
     * City
     *
     * @var CityInterface
     */
    private $city;

    /**
     * Message Manager
     *
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * Image Optimizer
     *
     * @var ImageOptimizerInterface
     */
    private $imageOptimizer;

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
     * @param MessageManagerInterface $messageManager
     * @param ImageOptimizerInterface $imageOptimizer
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize,
        CountryInterface $country,
        RegionInterface $region,
        CityInterface $city,
        MessageManagerInterface $messageManager,
        ImageOptimizerInterface $imageOptimizer
    ) {
        $this->imageOptimizer = $imageOptimizer;
        $this->messageManager = $messageManager;
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

        if ($cities->count() === 0) {
            $cities = $this->city->select()
                ->where([
                    ['country_id', '=', $user->countryId]
                ])->get();
        }

        $messages = $this->messageManager->getMessages(true);
        $successMessages = $this->messageManager->getSuccessMessages(true);
        $avatarPath = (!empty($user->getAvatar())) ? $user->getAvatar()->path : Index::AVATAR_PLACEHOLDER_PATH;

        $this->view('profile/settings.php',
            [
                'user' => $user,
                'avatarPath' => $avatarPath,
                'countries' => $countries,
                'regions' => $regions,
                'cities' => $cities,
                'messages' => $messages,
                'successMessages' => $successMessages,
                'imageOptimizer' => $this->imageOptimizer,
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
