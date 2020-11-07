<?php

namespace App\Api\Image;

/**
 * Interface ImageOptimizerInterface
 * @package App\Api\Uploader
 */
interface ImageOptimizerInterface
{
    /**
     * Resized images part of path
     */
    const RESIZED_IMAGES_FOLDER = '/media/resized/';

    /**
     * Resize image
     *
     * @param string $imageLocation
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return string
     */
    public function resizeImage(string $imageLocation, int $width, int $height, bool $crop = false): string;

    /**
     * Delete resized image
     *
     * @param string $imageLocation
     * @return void|bool
     */
    public function deleteResizeImage(string $imageLocation);
}
