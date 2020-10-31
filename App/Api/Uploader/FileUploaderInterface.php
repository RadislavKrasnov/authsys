<?php

namespace App\Api\Uploader;

/**
 * Interface FileUploaderInterface
 * @package App\Api\Uploader
 */
interface FileUploaderInterface
{
    /**
     * Upload file
     *
     * @param string $fieldName
     * @param string $path
     * @return false|void
     */
    public function upload(string $fieldName, string $path);

    /**
     * Array of files to upload
     *
     * @return array
     */
    public function getFiles(): array;

    /**
     * Set valid extensions
     *
     * @param array $extensions
     * @return void
     */
    public function setValidExtensions(array $extensions): void;

    /**
     * Set valid mime types
     *
     * @param array $mimeTypes
     * @return void
     */
    public function setValidMimeTypes(array $mimeTypes): void;

    /**
     * Set max file size
     *
     * @param int $bytes
     * @return void
     */
    public function setMaxFileSize(int $bytes): void;

    /**
     * Get file extension
     *
     * @param string $fileName
     * @return string
     */
    public function getFileExtension(string $fileName): string;
}
