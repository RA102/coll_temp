<?php

namespace common\gateways\pds;

use common\exceptions\ValidationException;
use common\gateways\pds\dto\LoginResponse;
use common\gateways\pds\dto\PersonCredentialResponse;
use common\gateways\pds\dto\ResetPasswordResponse;
use common\gateways\pds\transformers\LoginTransformer;
use common\gateways\pds\transformers\PersonTransformer;
use common\models\system\Setting;
use common\utils\httpClient\HttpClientFactory;
use common\utils\httpClient\RequestFactory;
use Karriere\JsonDecoder\JsonDecoder;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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
    private $requestFactory;

    /**
     * PdsGateway constructor.
     * @param HttpClientFactory $httpClientFactory
     * @param RequestFactory $requestFactory
     * @param array $config
     */
    public function __construct(HttpClientFactory $httpClientFactory, RequestFactory $requestFactory, $config = [])
    {
        $this->httpClient = $httpClientFactory->createHttpClient('pds', [
            'base_uri'    => $config['baseUrl'],
            'http_errors' => false, // disable throwing http exceptions
            'timeout'     => self::DEFAULT_TIMEOUT,
            'headers'     => [
                'Access'       => 'Bearer ' . Setting::getPdsToken(),
                'Content-Type' => 'application/json'
            ]
        ]);
        $this->requestFactory = $requestFactory;

        $this->jsonDecoder = new JsonDecoder();
        $this->jsonDecoder->register(new PersonTransformer());
        $this->jsonDecoder->register(new LoginTransformer());
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     * @throws \Exception
     */
    public function login(string $username, string $password): string
    {
        $body = [
            'indentity' => $username,
            'password'  => $password
        ];
        $request = $this->requestFactory->create('post', 'auth', [], json_encode($body));
        $response = $this->send($request);
        return $response->getBody()->getContents();
    }

    /**
     * @param string $token
     * @return LoginResponse
     * @throws \Exception
     */
    public function loginByToken(string $token): LoginResponse
    {
        $body = ['authToken' => $token];
        $request = $this->requestFactory->create('post', 'auth', [], json_encode($body));
        $response = $this->send($request);
        return $this->jsonDecoder->decode($response->getBody()->getContents(), LoginResponse::class);
    }

    /**
     * @param array $query
     * @param string $token
     * @param string $role
     * @return string
     */
    public function search(array $query, string $token, string $role)
    {
        $query_string = http_build_query($query);
        $headers = [
            'Authorization' => "Bearer {$token}",
            'Access-Role'   => $role
        ];
        $request = $this->requestFactory->create('get', "/person?{$query_string}", $headers);
        $response = $this->send($request);
        return $response->getBody()->getContents();
    }

    /**
     * @param array $attributes
     * @param string $token
     * @param string $role
     * @return string
     */
    public function createPerson(array $attributes, string $token, string $role)
    {
        $headers = [
            'Authorization' => "Bearer {$token}",
            'Access-Role'   => $role
        ];
        $request = $this->requestFactory->create('post', 'person', $headers, json_encode($attributes));
        $response = $this->send($request);
        return $response->getBody()->getContents();
    }

    /**
     * @param int $person_id
     * @param array $attributes
     * @param string $token
     * @param string $role
     * @return string
     */
    public function updatePerson(int $person_id, array $attributes, string $token, string $role): string
    {
        $headers = [
            'Authorization' => "Bearer {$token}",
            'Access-Role'   => $role
        ];
        $request = $this->requestFactory->create('put', "person/{$person_id}", $headers, json_encode($attributes));
        $response = $this->send($request);
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
        $body = [
            'indentity' => $identity,
            'type'      => $type
        ];
        $request = $this->requestFactory->create('post', 'person/reset-password', [], json_encode($body));
        $response = $this->send($request);
        return $this->jsonDecoder->decode($response->getBody()->getContents(), ResetPasswordResponse::class);
    }

    /**
     * @param string $hash
     * @param string $password
     * @param string $repassword
     * @return bool
     * @throws \Exception
     */
    public function changePassword(string $hash, string $password, string $repassword): bool
    {
        $body = [
            'hash'       => $hash,
            'password'   => $password,
            'repassword' => $repassword
        ];
        $request = $this->requestFactory->create('post', 'person/change-password', [], json_encode($body));
        $this->send($request);
        return true;
    }


    /**
     * @param int $person_id
     * @param string $email
     * @param string $token
     * @param string $type
     * @param string $role
     * @return PersonCredentialResponse
     * @throws \Exception
     */
    public function createPersonCredential(
        int $person_id,
        string $email,
        string $token,
        string $type,
        string $role
    ): PersonCredentialResponse {
        $body = [
            'person_id' => $person_id,
            'indentity' => $email,
            'name'      => $type,
            'status'    => self::PERSON_CREDENTIAL_CREATED_STATUS
        ];
        $headers = [
            'Authorization' => "Bearer {$token}",
            'Access-Role'   => $role
        ];
        $request = $this->requestFactory->create('post', 'person-credential', $headers, json_encode($body));
        $response = $this->send($request);
        return $this->jsonDecoder->decode($response->getBody()->getContents(), PersonCredentialResponse::class);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws ValidationException
     * @throws \Exception
     */
    private function send(RequestInterface $request): ResponseInterface
    {
        $response = $this->httpClient->send($request);

        if ($response->getStatusCode() === 422) {
            $rawErrors = json_decode($response->getBody()->getContents(), true);
            $errors = array_reduce($rawErrors, function ($acc, $error) {
                $acc[$error['field']][] = $error['message'];
                return $acc;
            }, []);

            throw new ValidationException(
                $response->getReasonPhrase(),
                0,
                $errors
            );
        }

        if ($response->getStatusCode() === 201 || $response->getStatusCode() === 200) {
            return $response;
        }

        throw new \Exception($response->getReasonPhrase());
    }
}