<?php

namespace Core\Api\Router;

/**
 * Interface ResponseInterface
 * @package Core\Api\Router
 */
interface ResponseInterface
{
    /**
     * Get Http version
     *
     * @return string
     */
    public function getVersion() :string;

    /**
     * Get Http headers
     *
     * @return array
     */
    public function getHeaders() :array;

    /**
     * Set Http version
     *
     * @param $version
     * @return mixed
     */
    public function setVersion(string $version);

    /**
     * Add Http header
     *
     * @param $header
     * @return \Core\Api\Router\ResponseInterface
     */
    public function addHeader(string $header);

    /**
     * Add Http headers
     *
     * @param array $headers
     * @return \Core\Api\Router\ResponseInterface
     */
    public function addHeaders(array $headers);

    /**
     * Send a Http header
     *
     * @return mixed
     */
    public function send();
}
