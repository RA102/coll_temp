<?php

namespace common\gateways\pds;

use common\gateways\pds\dto\PersonCredentialResponse;
use common\gateways\pds\dto\ResetPasswordResponse;
use common\utils\httpClient\HttpClientFactory;
use Karriere\JsonDecoder\JsonDecoder;

/**
 * // TODO: split according to logic
 * Class PdsGateway
 * @package common\gateways\pds
 */
class PdsGateway implements \yii\base\Configurable
{
    const PERSON_CREDENTIAL_CREATED_STATUS = 1;
    const DEFAULT_TIMEOUT = 20; // 20 seconds

    private $httpClient;
    private $jsonDecoder;

    /**
     * TODO: need better way to inject config, without implementing yii configurable interface and jsonDecoder initialization
     * PdsGateway constructor.
     * @param HttpClientFactory $httpClientFactory
     * @param array $config
     */
    public function __construct(HttpClientFactory $httpClientFactory, $config = [])
    {
        $this->httpClient = $httpClientFactory->createHttpClient('pds', [
            'base_uri'    => $config['baseUrl'],
            'http_errors' => false, // disable throwing http exceptions
            'timeout'     => self::DEFAULT_TIMEOUT,
            'headers'     => [
                'Access'      => "Bearer {$config['accessToken']}",
                'Access-Role' => 'superadmin'
            ]
        ]);
        $this->jsonDecoder = new JsonDecoder();
    }

    /**
     * @param array $attributes
     * @param string $token
     * @return mixed
     * @throws \Exception
     */
    public function createPerson(array $attributes, string $token)
    {
        $response = $this->httpClient->post('person', [
            'json'    => $attributes,
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ]
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception("Couldn't create person");
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param string $identity
     * @param string $type
     * @return ResetPasswordResponse
     * @throws \Exception
     */
    public function resetPassword(string $identity, string $type): ResetPasswordResponse
    {
        $response = $this->httpClient->post('person/reset-password', [
            'json' => [
                'indentity' => $identity,
                'type'      => $type
            ],
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception("Couldn't reset password");
        }

        // TODO: maybe better to use logic like in PdsPersonInterface and remove unnecessary package
        return $this->jsonDecoder->decode($response->getBody()->getContents(), ResetPasswordResponse::class);
    }

    /**
     * @param string $hash
     * @param string $password
     * @param string $repassword
     * @return bool
     * @throws \Exception
     */
    public function changePassword(string $hash, string $password, string $repassword)
    {
        $response = $this->httpClient->post('person/change-password', [
            'json' => [
                'hash'       => $hash,
                'password'   => $password,
                'repassword' => $repassword
            ]
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception("Couldn't change password");
        }

        return true;
    }


    /**
     * @param int $person_id
     * @param string $email
     * @param string $token
     * @param string $type
     * @return PersonCredentialResponse
     * @throws \Exception
     */
    public function createPersonCredential(
        int $person_id,
        string $email,
        string $token,
        string $type
    ): PersonCredentialResponse {
        $response = $this->httpClient->post('person-credential', [
            'json'    => [
                'person_id' => $person_id,
                'indentity' => $email,
                'name'      => $type,
                'status'    => self::PERSON_CREDENTIAL_CREATED_STATUS
            ],
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ]
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception("Couldn't create person credential");
        }

        return $this->jsonDecoder->decode($response->getBody()->getContents(), PersonCredentialResponse::class);
    }

    /**
     * @param int $person_id
     * @param string $email
     * @param string $token
     * @param string $type
     * @param int $status
     * @return PersonCredentialResponse
     * @throws \Exception
     */
    public function setPersonCredentialStatus(
        int $person_id,
        string $email,
        string $token,
        string $type,
        int $status
    ): PersonCredentialResponse {
        $id = implode(',', [$person_id, $email, $type, $status]);
        $response = $this->httpClient->put("person-credential/{$id}", [
            'json'    => [
                'person_id' => $person_id,
                'indentity' => $email,
                'name'      => $type,
                'status'    => $status
            ],
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ]
        ]);

        if ($response->getStatusCode() !== 201) {
            throw new \Exception('Error occurred');
        }

        return $this->jsonDecoder->decode($response->getBody()->getContents(), PersonCredentialResponse::class);
    }


}