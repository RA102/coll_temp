<?php

namespace common\utils\httpClient;

use common\utils\Logger;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class HttpClientFactory
{
    /**
     * @param string $namespace
     * @param array $options @see http://docs.guzzlephp.org/en/stable/request-options.html
     * @return Client
     */
    public function createHttpClient(string $namespace, array $options = [])
    {
        $stack = HandlerStack::create();

        if (YII_DEBUG) {
            $loggingMiddleware = new LoggerMiddleware(
                $this->getLogger($namespace),
                new MessageFormatter("{method} {uri} {version}\n{req_body}\n\n{code} {phrase} \nContent-Type: {req_header_content-type}\n{res_body}")
            );
            $loggingMiddleware->setLogLevel(function (ResponseInterface $response = null) {
                if ($response && $response->getStatusCode() >= 300) {
                    return LogLevel::ERROR;
                }
                return LogLevel::INFO;
            });
            $stack->push($loggingMiddleware);
        }

        $defaultConfig = [
            'handler' => $stack
        ];

        return new Client(array_merge($defaultConfig, $options));
    }

    public function getLogger(string $namespace): LoggerInterface
    {
        return new Logger("http-client:$namespace");
    }

}