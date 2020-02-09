<?php

namespace Core\Api\Router;

interface ResponseInterface
{
    const VERSION = 'HTTP/1.1';

    public function getVersion();

    public function getHeaders();

    public function setVersion($version);

    public function addHeader($header);

    public function addHeaders(array $headers);

    public function send();
}
