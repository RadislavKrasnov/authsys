<?php

namespace Core\Router;

use Core\Api\Router\RequestInterface;
use Core\Api\Url\UrlInterface;

/**
 * Class Request
 * @package Core\Router
 */
class Request implements RequestInterface
{
    /**
     * Requested Url
     *
     * @var
     */
    private $url;

    /**
     * Requested Url parameters
     *
     * @var
     */
    private $params;

    /**
     * @var UrlInterface
     */
    private $urlParser;

    /**
     * Request constructor.
     * @param UrlInterface $urlParser
     */
    public function __construct(
        UrlInterface $urlParser
    ) {
        $this->urlParser = $urlParser;
        $this->setUrl($this->urlParser->parseUrl());
    }

    /**
     * Get request Url
     *
     * @return string
     */
    public function getUrl() :string
    {
        return $this->url;
    }

    /**
     * Get Request parameter from Url
     *
     * @param $key
     * @return string
     */
    public function getParam($key) :string
    {
        if (!isset($this->params[$key])) {
            throw new \InvalidArgumentException('Parameter with key '. $key. 'doesn\'t exist');
        }

        return $this->params[$key];
    }

    /**
     * Get Request parameters from Url
     *
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * Get Post request parameters' values
     *
     * @return array|null
     */
    public function getPostValues(): ?array
    {
        return $_POST;
    }

    /**
     * Get parameters' values of Get request
     *
     * @return array|null
     */
    public function getGetValues(): ?array
    {
        return $_GET;
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getRequestMethod() :string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Set parameter from Url
     *
     * @param $key
     * @param $value
     * @return \Core\Api\Router\RequestInterface
     */
    public function setParam(string $key, string $value)
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Set parameters from Url
     *
     * @param array $params
     * @return \Core\Api\Router\RequestInterface
     */
    public function setParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->setParam($key, $value);
        }

        return $this;
    }

    /**
     * Set request Url
     *
     * @param $url
     * @return \Core\Api\Router\RequestInterface
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }
}
