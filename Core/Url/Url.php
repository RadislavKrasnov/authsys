<?php

namespace Core\Url;

use Core\Api\Url\UrlInterface;

/**
 * Class Url
 * @package Core\Url
 */
class Url implements UrlInterface
{
    /**
     * Parse Url
     *
     * @return string
     */
    public function parseUrl() :string
    {
        $url = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if (empty($url)) {
            return '/';
        }

        return $url;
    }

    /**
     * Match requested Url with path Url form routes
     *
     * @param $path
     * @param $requestUrl
     * @return bool
     */
    public function matchPathAndRequestUrl($path, $requestUrl): bool
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

        if (empty($pathChecker[0]) && empty($pathChecker[1])) {
            $pathChecker = $pathElements;
        }
        $pathChecker = implode('/', $pathChecker);

        return $pathChecker === $requestUrl;
    }

    /**
     * Parse parameters from Url
     *
     * @param $path
     * @param $requestUrl
     * @return array
     */
    public function parseParams($path, $requestUrl): array
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
