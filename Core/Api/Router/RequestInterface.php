<?php

namespace Core\Api\Router;

interface RequestInterface
{
    public function getUrl();

    public function getParam($key);

    public function getParams() :array;

    public function getPostValues() :array;

    public function getRequestMethod();

    public function setUrl($url);

    public function setParam($key, $value);

    public function setParams(array $params);
}
