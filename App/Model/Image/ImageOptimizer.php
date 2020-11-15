<?php

namespace App\Model\Image;

use App\Api\Image\ImageOptimizerInterface;

/**
 * Class ImageOptimizer
 * @package App\Model\Image
 */
class ImageOptimizer implements ImageOptimizerInterface
{
    /**
     * Resize image
     *
     * @param string $imagePath
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return string
     */
    public function resizeImage(string $imagePath, int $width, int $height, bool $crop = false): string
    {
        $imageLocation = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
        $resizedImagesFolder = self::RESIZED_IMAGES_FOLDER . $width . 'x' . $height . DIRECTORY_SEPARATOR;
        $resizedImagePath = preg_replace('/\/media\//', $resizedImagesFolder, $imagePath);
        $resizedImageLocation = $_SERVER['DOCUMENT_ROOT'] . $resizedImagePath;

        if (file_exists($resizedImageLocation)) {
            return $resizedImagePath;
        }

        $info = getimagesize($imageLocation);
        list($imageWidth, $imageHeight) = $info;
        $ratio = $imageWidth / $imageHeight;

        if ($crop) {
            if ($imageWidth > $imageHeight) {
                $imageWidth = ceil(
                    $imageWidth - ($imageWidth * abs($ratio - $imageWidth / $imageHeight))
                );
            } else {
                $imageHeight = ceil(
                    $imageHeight - ($imageHeight * abs($ratio - $imageWidth / $imageHeight))
                );
            }
            $newWidth = $width;
            $newHeight = $height;
        } else {
            if ($imageWidth / $imageHeight > $ratio) {
                $newWidth = $height * $ratio;
                $newHeight = $height;
            } else {
                $newHeight = $width / $ratio;
                $newWidth = $width;
            }
        }

        $source = null;

        switch ($info['mime']) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($imageLocation);
                break;
            case 'image/png':
                $source = imagecreatefrompng($imageLocation);
                break;
        }

        $destination = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled(
            $destination,
            $source,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $imageWidth,
            $imageHeight
        );
        $this->compressImage($destination, $resizedImageLocation, 75, $info['mime']);
        imagedestroy($destination);

        return $resizedImagePath;
    }

    /**
     * Compress image
     *
     * @param resource $image
     * @param string $destination
     * @param int $quality
     * @param string $mime
     * @return void
     */
    private function compressImage($image, string $destination, int $quality, string $mime): void
    {
        $pathInfo = pathinfo($destination);

        if (!is_dir($pathInfo['dirname'])) {
            mkdir($pathInfo['dirname'], 0775, true);
        }

        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($image, $destination, $quality);
                break;
            case 'image/png':
                $quality = ($quality * 9) / 100;
                imagepng($image, $destination, $quality);
                break;
        }
    }

    /**
     * Delete resized image
     *
     * @param string $imagePath
     * @return void|bool
     */
    public function deleteResizeImage(string $imagePath)
    {
        if (empty($imagePath)) {
            return false;
        }

        $directories = scandir(
            $_SERVER['DOCUMENT_ROOT'] . rtrim(self::RESIZED_IMAGES_FOLDER, '/')
        );

        foreach ($directories as $index => $directory) {

            if ($index < 2) {
                continue;
            }

            $resizedImagesFolder = self::RESIZED_IMAGES_FOLDER . $directory . DIRECTORY_SEPARATOR;
            $resizedImagePath = preg_replace('/\/media\//', $resizedImagesFolder, $imagePath);
            $resizedImageLocation = $_SERVER['DOCUMENT_ROOT'] . $resizedImagePath;

            if (file_exists($resizedImageLocation)) {
                unlink($resizedImageLocation);
            }
        }
    }
}
