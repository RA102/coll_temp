<?php

namespace common\utils\httpClient;

use GuzzleHttp\Psr7\Request;

class RequestFactory
{
    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param $body
     * @return Request
     */
    public function create(string $method, string $uri, array $headers = [], $body)
    {
        return new Request($method, $uri, $headers, $body);
    }

}