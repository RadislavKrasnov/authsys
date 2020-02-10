<?php

namespace Core\Api\Router;

interface ResponseInterface
{
    public function getVersion();

    public function getHeaders();

    public function setVersion($version);

    public function addHeader($header);

    public function addHeaders(array $headers);

    public function send();
}
