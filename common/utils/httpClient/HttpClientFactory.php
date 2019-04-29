<?php

namespace common\utils\httpClient;

use common\utils\Logger;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

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
            // NOTE: There is a stream-related side effects and because of logging response body is empty
            // @see https://github.com/guzzle/guzzle/issues/1582#issuecomment-397583084
            $mapResponse = Middleware::mapResponse(function (ResponseInterface $response) {
                $response->getBody()->rewind();
                return $response;
            });
            $stack->push($mapResponse);
            $stack->push(
                Middleware::log(
                    $this->getLogger($namespace),
                    new MessageFormatter('{request} - {response}')
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