<?php

namespace Core\Model\Url;

use Core\Api\Url\UrlInterface;

class Url implements UrlInterface
{
    public static function parseUrl() :string
    {
        return rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    public static function matchPathAndRequestUrl($path, $requestUrl): bool
    {
        $pathElements = explode('/', $path);
        $urlElements = explode('/', $requestUrl);
        $pathChecker = [];

        foreach ($urlElements as $key => $element) {
            if (
                (array_key_exists($key, $pathElements)) &&
                (count($pathElements) == count($urlElements)) &&
                ($element === $pathElements[$key] ||
                    strpos($pathElements[$key], '{') !== false)
            ) {
                $pathChecker[] = $element;
            } else {
                $pathChecker = $pathElements;

                break;
            }
        }
        $pathChecker = implode('/', $pathChecker);

        return $pathChecker === $requestUrl;
    }

    public static function parseParams($path, $requestUrl): array
    {
        $pathElements = explode('/', $path);
        $urlElements = explode('/', $requestUrl);
        $params = [];

        foreach ($urlElements as $key => $element) {
            if (strpos($pathElements[$key], '{') !== false) {
                $params[trim($pathElements[$key], '{}')] = $element;
            }
        }

        return $params;
    }
}
