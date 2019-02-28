<?php

namespace common\utils\httpClient;

class HttpClientFactory {

    /**
     * @param array $options @see http://docs.guzzlephp.org/en/stable/request-options.html
     * @return \GuzzleHttp\Client
     */
    public function createHttpClient(array $options = []) {
        // TODO: Consider implementing psr-18 http client and psr-7 requestFactory for interoperability,
        // TODO: add logging middleware
        $client = new \GuzzleHttp\Client($options);

        return $client;
    }
}