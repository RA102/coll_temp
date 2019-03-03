<?php

namespace common\utils\httpClient;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;
use common\utils\Logger;

class HttpClientFactory
{
    /**
     * @param string $namespace
     * @param array $options @see http://docs.guzzlephp.org/en/stable/request-options.html
     * @return \GuzzleHttp\Client
     */
    public function createHttpClient(string $namespace, array $options = [])
    {
        $defaultConfig = [];

        if (YII_DEBUG) {
            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $this->getLogger($namespace),
                    new MessageFormatter('{req_body} - {res_body}')
                )
            );

            $defaultConfig['handler'] = $stack;
        }

        // TODO: Consider implementing psr-18 http client and psr-7 requestFactory for interoperability,
        $client = new \GuzzleHttp\Client(array_merge($defaultConfig, $options));

        return $client;
    }

    public function getLogger(string $namespace): LoggerInterface
    {
        return new Logger("http-client:$namespace");
    }

}