<?php

namespace App\Controller\User\Background;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Psr\Log\LoggerInterface;
use App\Api\Authorization\AuthorizeInterface;
use App\Api\Uploader\FileUploaderInterface;
use App\Api\User\BackgroundPhotoInterface;
use App\Api\Image\ImageOptimizerInterface;

/**
 * Class Uploader
 * @package App\Controller\User\Background
 */
class Uploader extends Controller
{
    /**
     * Background photo path
     */
    const BACKGROUND_PHOTO_PATH = '/media/profile/background';

    /**
     * Authorize
     *
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * File Uploader
     *
     * @var FileUploaderInterface
     */
    private $fileUploader;

    /**
     * Background photo
     *
     * @var BackgroundPhotoInterface
     */
    private $backgroundPhoto;

    /**
     * Image Optimizer
     *
     * @var ImageOptimizerInterface
     */
    private $imageOptimizer;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Uploader constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param AuthorizeInterface $authorize
     * @param FileUploaderInterface $fileUploader
     * @param BackgroundPhotoInterface $backgroundPhoto
     * @param ImageOptimizerInterface $imageOptimizer
     * @param LoggerInterface $logger
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        AuthorizeInterface $authorize,
        FileUploaderInterface $fileUploader,
        BackgroundPhotoInterface $backgroundPhoto,
        ImageOptimizerInterface $imageOptimizer,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->imageOptimizer = $imageOptimizer;
        $this->backgroundPhoto = $backgroundPhoto;
        $this->fileUploader = $fileUploader;
        $this->authorize = $authorize;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Background photo uploader
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return void
     */
    public function upload(RequestInterface $request, ResponseInterface $response): void
    {
        $this->isAuthorized();
        $user = $this->authorize->getLoggedInUser();
        $files = $this->fileUploader->getFiles();
        $extension = $this->fileUploader->getFileExtension($files['background-image']['name']);
        $backgroundPhotoPath = self::BACKGROUND_PHOTO_PATH . DIRECTORY_SEPARATOR .
            date('mdYHis') . '.' . $extension;
        $backgroundPhotoLocation = $_SERVER['DOCUMENT_ROOT'] . $backgroundPhotoPath;
        $this->fileUploader->setValidExtensions(['png', 'jpg', 'jpeg']);
        $this->fileUploader->setValidMimeTypes(['image/png', 'image/jpeg']);

        $backgroundPhoto = $user->getBackgroundPhoto();
        $oldBackgroundPhotoPath = '';

        if (!empty($backgroundPhoto)) {
            $oldBackgroundPhotoPath = $backgroundPhoto->path;
            $backgroundPhoto->path = $backgroundPhotoPath;
        } else {
            $backgroundPhoto = $this->backgroundPhoto->newInstance();
            $backgroundPhoto->path = $backgroundPhotoPath;
            $backgroundPhoto->userId = $user->id;
        }

        try {
            $this->fileUploader->upload('background-image', $backgroundPhotoLocation);
            $backgroundPhoto->save();
            $this->deleteOldBackgroundPhotoFile($oldBackgroundPhotoPath);
            $this->deleteResizedBackgroundPhoto($oldBackgroundPhotoPath);
            $this->redirect->redirect('/index');
        } catch (\Exception $exception) {
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

    /**
     * Delete an old background photo file
     *
     * @param string $backgroundPhotoPath
     * @return bool
     */
    private function deleteOldBackgroundPhotoFile(string $backgroundPhotoPath): bool
    {
        if (empty($backgroundPhotoPath)) {
            return false;
        }

        $backgroundPhotoLocation = $_SERVER['DOCUMENT_ROOT'] . $backgroundPhotoPath;

        return unlink($backgroundPhotoLocation);
    }

    /**
     * Delete resized background photo file
     *
     * @param string $backgroundPhotoPath
     * @return bool|void
     */
    private function deleteResizedBackgroundPhoto(string $backgroundPhotoPath)
    {
        return $this->imageOptimizer->deleteResizeImage($backgroundPhotoPath);
    }
}
