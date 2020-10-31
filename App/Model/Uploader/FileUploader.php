<?php

namespace App\Model\Uploader;

use App\Api\Uploader\FileUploaderInterface;
use Core\Api\Psr\Log\LoggerInterface;
use Core\Api\Messages\MessageManagerInterface;

/**
 * Class FileUploader
 * @package App\Model\Uploader
 */
class FileUploader implements FileUploaderInterface
{
    /**
     * Bytes in one megabyte
     */
    const MEGABYTE_IN_BYTES = 1048576;

    /**
     * List of valid extensions
     *
     * @var array
     */
    private $extensions = [];

    /**
     * List of valid mime types
     *
     * @var array
     */
    private $mimeTypes = [];

    /**
     * Max file size to upload
     *
     * @var int
     */
    private $maxFileSize = 2097152;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Message Manager
     *
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * FileUploader constructor.
     *
     * @param LoggerInterface $logger
     * @param MessageManagerInterface $messageManager
     */
    public function __construct(
        LoggerInterface $logger,
        MessageManagerInterface $messageManager
    ) {
        $this->logger = $logger;
        $this->messageManager = $messageManager;
    }

    /**
     * Upload file
     *
     * @param string $fieldName
     * @param string $path
     * @return false|void
     */
    public function upload(string $fieldName, string $path)
    {
        $files = $this->getFiles();

        if (!isset($files[$fieldName])) {
            return false;
        }

        $fileName = $files[$fieldName]['name'];
        $fileTempName = $files[$fieldName]['tmp_name'];
        $fileSize = $files[$fieldName]['size'];
        $fileType = $files[$fieldName]['type'];
        $fileExtension = $this->getFileExtension($fileName);

        if (!in_array($fileExtension, $this->extensions)) {
            $message = $fileExtension . ' file extension isn\'t allowed to be uploaded';
            $this->logger->warning($message);
            $this->messageManager->addMessage($message);

            return false;
        }

        if (!in_array($fileType, $this->mimeTypes)) {
            $message = $fileType . ' mime type isn\'t allowed to be uploaded';
            $this->logger->warning($message);
            $this->messageManager->addMessage($message);

            return false;
        }

        if ($fileSize > $this->maxFileSize) {
            $megabytes = number_format($this->maxFileSize / self::MEGABYTE_IN_BYTES, 0);
            $message = 'The file size shouldn\'t be more then ' . $megabytes . 'MB';
            $this->logger->warning($message);
            $this->messageManager->addMessage($message);

            return false;
        }

        move_uploaded_file($fileTempName, $path);
    }

    /**
     * Array of files to upload
     *
     * @return array
     */
    public function getFiles(): array
    {
        return $_FILES;
    }

    /**
     * Set valid extensions
     *
     * @param array $extensions
     * @return void
     */
    public function setValidExtensions(array $extensions): void
    {
        $this->extensions = $extensions;
    }

    /**
     * Set valid mime types
     *
     * @param array $mimeTypes
     * @return void
     */
    public function setValidMimeTypes(array $mimeTypes): void
    {
        $this->mimeTypes = $mimeTypes;
    }

    /**
     * Set max file size
     *
     * @param int $bytes
     * @return void
     */
    public function setMaxFileSize(int $bytes): void
    {
        $this->maxFileSize = $bytes;
    }

    /**
     * Get file extension
     *
     * @param string $fileName
     * @return string
     */
    public function getFileExtension(string $fileName): string
    {
        $fileNameParts = explode('.', $fileName);
        $extension = end($fileNameParts);

        return $extension;
    }
}
