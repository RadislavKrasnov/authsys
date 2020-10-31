<?php

namespace App\Controller\User\Avatar;

use Core\Api\Session\SessionInterface;
use Core\Api\Url\RedirectInterface;
use Core\Api\View\ViewInterface;
use Core\Controllers\Controller;
use Core\Api\Router\RequestInterface;
use Core\Api\Router\ResponseInterface;
use App\Api\Uploader\FileUploaderInterface;

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
     * Uploader constructor.
     *
     * @param ViewInterface $view
     * @param SessionInterface $session
     * @param RedirectInterface $redirect
     * @param FileUploaderInterface $fileUploader
     */
    public function __construct(
        ViewInterface $view,
        SessionInterface $session,
        RedirectInterface $redirect,
        FileUploaderInterface $fileUploader
    ) {
        $this->fileUploader = $fileUploader;
        parent::__construct($view, $session, $redirect);
    }

    /**
     * Upload user's avatar
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function upload(RequestInterface $request, ResponseInterface $response): void
    {
        $files = $this->fileUploader->getFiles();
        $extension = $this->fileUploader->getFileExtension($files['image']['name']);
        $avatarPath = $_SERVER['DOCUMENT_ROOT'] . self::AVATAR_IMAGE_PATH . DIRECTORY_SEPARATOR .
            date('mdYHis') . '.' . $extension;
        $this->fileUploader->setValidExtensions(['png', 'jpg', 'jpeg']);
        $this->fileUploader->setValidMimeTypes(['image/png', 'image/jpeg']);
        $this->fileUploader->upload('image', $avatarPath);
        $this->redirect->redirect('/index');
    }
}
