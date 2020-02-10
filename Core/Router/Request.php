<?php

namespace Core\Router;

use Core\Api\Router\RequestInterface;
use Core\Model\Url\Url;

class Request implements RequestInterface
{
    private $url;

    private $params;

    public function __construct() {
        $this->setUrl(Url::parseUrl());
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getParam($key)
    {
        if (!isset($this->params[$key])) {
            throw new \InvalidArgumentException('Parameter with key '. $key. 'doesn\'t exist');
        }

        return $this->params[$key];
    }

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function getPostValues(): ?array
    {
        return $_POST;
    }

    public function getGetValues(): ?array
    {
        return $_GET;
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function setParam($key, $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function setParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }

        return $this;
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
