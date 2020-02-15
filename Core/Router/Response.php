<?php

namespace Core\Router;

use Core\Api\Router\ResponseInterface;

/**
 * Class Response
 * @package Core\Router
 */
class Response implements ResponseInterface
{
    /**
     * Http version
     *
     * @var string
     */
    private $version = 'HTTP/1.1';

    /**
     * Http headers
     *
     * @var
     */
    private $headers = [];

    /**
     * Get Http version
     *
     * @return string
     */
    public function getVersion() :string
    {
        return $this->version;
    }

    /**
     * Get Http headers
     *
     * @return array
     */
    public function getHeaders() :array
    {
        return $this->headers;
    }

    /**
     * Set Http version
     *
     * @param $version
     * @return mixed|void
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * Add Http header
     *
     * @param $header
     * @return \Core\Api\Router\ResponseInterface
     */
    public function addHeader(string $header)
    {
        $this->headers[] = $header;

        return $this;
    }

    /**
     * Add Http headers
     *
     * @param array $headers
     * @return \Core\Api\Router\ResponseInterface
     */
    public function addHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }

        return $this;
    }

    /**
     * Send a Http header
     *
     * @return mixed|void
     */
    public function send()
    {
        if(!headers_sent()) {
            foreach ($this->headers as $header) {
                header("$this->version $header", true);
            }
        }
    }
}
