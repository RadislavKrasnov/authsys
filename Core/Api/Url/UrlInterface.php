<?php

namespace Core\Api\Url;

interface UrlInterface
{
    public static function parseUrl() :string;

    public static function matchPathAndRequestUrl($path, $requestUrl) :bool;

    public static function parseParams($path, $requestUrl) :array;
}
