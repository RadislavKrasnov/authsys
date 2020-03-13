<?php

namespace Core\Api\Url;

/**
 * Interface UrlInterface
 * @package Core\Api\Url
 */
interface UrlInterface
{
    /**
     * Parse Url
     *
     * @return string
     */
    public function parseUrl() :string;

    /**
     * Match requested Url with path Url form routes
     *
     * @param $path
     * @param $requestUrl
     * @return bool
     */
    public function matchPathAndRequestUrl($path, $requestUrl) :bool;

    /**
     * Parse parameters from Url
     *
     * @param $path
     * @param $requestUrl
     * @return array
     */
    public function parseParams($path, $requestUrl) :array;
}
