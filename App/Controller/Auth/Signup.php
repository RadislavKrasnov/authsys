<?php

namespace App\Controller\Auth;

use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use App\Controller\Auth\Index;
use App\Api\Geo\CountryInterface;

/**
 * Class Signup
 * @package App\Controller\Auth
 */
class Signup extends Controller
{
    /**
     * @var CountryInterface
     */
    private $country;

    /**
     * Signup constructor.
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
     * Show form for sign up
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function showForm(RequestInterface $request, ResponseInterface $response)
    {
        $countries = $this->country->getAll();
        $this->view('auth/signup.php', ['countries' => $countries], Index::AUTH_TEMPLATE);
    }
}
