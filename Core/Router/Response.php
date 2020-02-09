<?php

namespace Core\Router;

use Core\Api\Router\ResponseInterface;

class Response implements ResponseInterface
{
    private $version;

    private $headers;

    public function getVersion()
    {
        return $this->version;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;

        return $this;
    }

    public function addHeaders(array $headers)
    {
        foreach ($headers as $header) {
            $this->addHeader($header);
        }

        return $this;
    }

    public function send()
    {
        if(!headers_sent()) {
            foreach ($this->headers as $header) {
                header("$this->version $header", true);
            }
        }
    }
}
