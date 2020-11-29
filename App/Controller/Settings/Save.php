<?php

namespace App\Controller\Settings;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Validation\ValidatorInterface;
use Core\Api\Messages\MessageManagerInterface;
use Core\Api\Psr\Log\LoggerInterface;
use App\Api\Authorization\AuthorizeInterface;

/**
 * Class Save
 * @package App\Controller\Settings
 */
class Save extends Controller
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Save constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param ValidatorInterface $validator
     * @param MessageManagerInterface $messageManager
     * @param AuthorizeInterface $authorize
     * @param LoggerInterface $logger
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        ValidatorInterface $validator,
        MessageManagerInterface $messageManager,
        AuthorizeInterface $authorize,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->authorize = $authorize;
        $this->messageManager = $messageManager;
        $this->validator = $validator;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Save user account settings
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function save(RequestInterface $request, ResponseInterface $response): void
    {
        $this->isAuthorized();
        $data = $request->getPostValues();

        $rules = [
            'first-name' => ['required', 'alphanumeric'],
            'last-name' => ['required', 'alphanumeric'],
            'birth-date' => ['required', 'usa_date_format'],
            'country' => ['required', 'numeric'],
            'region' => ['numeric'],
            'city' => ['required', 'numeric'],
        ];

        $this->validator->validate($data, $rules);
        $errors = $this->validator->errors();

        if (!empty($errors)) {
            $messages = [];

            foreach ($errors as $error) {
                foreach ($error as $message) {
                    $messages[] = $message;
                }
            }

            $this->messageManager->addMessages($messages);
            $this->redirect->redirect('/auth/account/settings');
        }

        $this->updateUserSettings($data);
        $this->redirect->redirect('/auth/account/settings');
    }

    /**
     * Update user settings
     *
     * @param array $data
     * @return void
     */
    private function updateUserSettings(array $data): void
    {
        try {
            $user = $this->authorize->getLoggedInUser();
            $user->firstName = htmlspecialchars($data['first-name']);
            $user->lastName = htmlspecialchars($data['last-name']);
            $user->birthDate = htmlspecialchars($data['birth-date']);
            $user->countryId = htmlspecialchars($data['country']);
            $user->cityId = htmlspecialchars($data['city']);

            if (array_key_exists('region', $data) && !empty($data['region'])) {
                $user->regionId = htmlspecialchars($data['region']);
            } else {
                $user->regionId = null;
            }

            $user->save();
        } catch (\Exception $exception) {
            $this->messageManager->addMessage(
                'Error: The data has not been updated because of error during the update process'
            );
            $this->logger->error($exception->getMessage());
        }
    }

    /**
     * Check if user is authorized
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
