<?php

namespace common\gateways\bilimal;

use common\utils\httpClient\HttpClientFactory;

class BilimalNotificationsGateway {

    const DEFAULT_TIMEOUT = 20; // 20 seconds
    const DEFAULT_FROM_EMAIL = "noreply@bilimal.kz";

    public $accessToken;

    private $httpClient;

    /**
     * BilimalNotificationsGateway constructor.
     * @param HttpClientFactory $httpClientFactory
     */
    public function __construct(HttpClientFactory $httpClientFactory, array $config = [])
    {
        $this->httpClient = $httpClientFactory->createHttpClient('bilimal-notifications', [
            'base_uri' => 'https://api.bilimal.kz/notice',
            'http_errors' => false, // disable throwing http exceptions
            'timeout' => self::DEFAULT_TIMEOUT
        ]);
    }

    /**
     * @param string $title
     * @param string $message
     * @param array $addresses
     * @param string $from
     * @return bool
     */
    public function sendEmailNotification( string $title, string $message, array $addresses, string $from = self::DEFAULT_FROM_EMAIL)
    {
        $response = $this->httpClient->request('POST', 'notice/email', [
            'json' => [
                'addressees' => $addresses,
                'from' => $from,
                'message' => $message,
                'title' => $title,
            ],
            'headers' => [
                'Access-Token' => $this->accessToken
            ]
        ]);

        return $response->getStatusCode() === 201;
    }
}