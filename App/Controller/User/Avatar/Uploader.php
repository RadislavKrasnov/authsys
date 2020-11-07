<?php

namespace App\Controller\User\Avatar;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use Core\Api\Psr\Log\LoggerInterface;
use App\Api\Uploader\FileUploaderInterface;
use App\Api\Authorization\AuthorizeInterface;
use App\Api\User\AvatarInterface;
use App\Api\Image\ImageOptimizerInterface;

/**
 * Class Uploader
 * @package App\Controller\User\Avatar
 */
class Uploader extends Controller
{
    /**
     * Avatar image path
     */
    const AVATAR_IMAGE_PATH = '/media/profile/avatar';

    /**
     * File uploader
     *
     * @var FileUploaderInterface
     */
    private $fileUploader;

    /**
     * Authorize
     *
     * @var AuthorizeInterface
     */
    private $authorize;

    /**
     * Avatar
     *
     * @var AvatarInterface
     */
    private $avatar;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Image Optimizer
     *
     * @var ImageOptimizerInterface
     */
    private $imageOptimizer;

    /**
     * Uploader constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param FileUploaderInterface $fileUploader
     * @param AuthorizeInterface $authorize
     * @param AvatarInterface $avatar
     * @param LoggerInterface $logger
     * @param ImageOptimizerInterface $imageOptimizer
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        FileUploaderInterface $fileUploader,
        AuthorizeInterface $authorize,
        AvatarInterface $avatar,
        LoggerInterface $logger,
        ImageOptimizerInterface $imageOptimizer
    ) {
        $this->imageOptimizer = $imageOptimizer;
        $this->logger = $logger;
        $this->avatar = $avatar;
        $this->authorize = $authorize;
        $this->fileUploader = $fileUploader;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Upload user's avatar
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
        $extension = $this->fileUploader->getFileExtension($files['image']['name']);
        $avatarLocation = $_SERVER['DOCUMENT_ROOT'] . self::AVATAR_IMAGE_PATH . DIRECTORY_SEPARATOR .
            date('mdYHis') . '.' . $extension;
        $avatarPath = self::AVATAR_IMAGE_PATH . DIRECTORY_SEPARATOR .
            date('mdYHis') . '.' . $extension;
        $this->fileUploader->setValidExtensions(['png', 'jpg', 'jpeg']);
        $this->fileUploader->setValidMimeTypes(['image/png', 'image/jpeg']);

        $avatar = $oldAvatar = $user->getAvatar();
        $oldAvatarPath = '';

        if (!empty($avatar)) {
            $oldAvatarPath = $avatar->path;
            $avatar->path = $avatarPath;
        } else {
            $avatar = $this->avatar->newInstance();
            $avatar->path = $avatarPath;
            $avatar->userId = $user->id;
        }

        try {
            $this->fileUploader->upload('image', $avatarLocation);
            $avatar->save();
            $this->deleteOldAvatarImageFile($oldAvatarPath);
            $this->deleteResizedAvatarImage($oldAvatarPath);
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
     * Delete old avatar file from file system
     *
     * @param string $avatarPath
     * @return bool
     */
    private function deleteOldAvatarImageFile(string $avatarPath): bool
    {
        if (empty($avatarPath)) {
            return false;
        }

        $avatarLocation = $_SERVER['DOCUMENT_ROOT'] . $avatarPath;

        return unlink($avatarLocation);
    }

    /**
     * Delete resized avatar image
     *
     * @param string $avatarPath
     * @return bool|void
     */
    private function deleteResizedAvatarImage(string $avatarPath)
    {
        return $this->imageOptimizer->deleteResizeImage($avatarPath);
    }
}
