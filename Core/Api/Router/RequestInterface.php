<?php

namespace Core\Api\Router;

/**
 * Interface RequestInterface
 * @package Core\Api\Router
 */
interface RequestInterface
{
    /**
     * Get request Url
     *
     * @return string
     */
    public function getUrl() :string;

    /**
     * Get Request parameter from Url
     *
     * @param $key
     * @return string
     */
    public function getParam($key) :string;

    /**
     * Get Request parameters from Url
     *
     * @return array|null
     */
    public function getParams(): ?array;

    /**
     * Get Post request parameters' values
     *
     * @return array|null
     */
    public function getPostValues(): ?array;

    /**
     * Get parameters' values of Get request
     *
     * @return array|null
     */
    public function getGetValues(): ?array;

    /**
     * Get request method
     *
     * @return string
     */
    public function getRequestMethod() :string;

    /**
     * Set request Url
     *
     * @param $url
     * @return \Core\Api\Router\RequestInterface
     */
    public function setUrl(string $url);

    /**
     * Set parameter from Url
     *
     * @param $key
     * @param $value
     * @return \Core\Api\Router\RequestInterface
     */
    public function setParam(string $key, string $value);

    /**
     * Set parameters from Url
     *
     * @param array $params
     * @return \Core\Api\Router\RequestInterface
     */
    public function setParams(array $params);
}
