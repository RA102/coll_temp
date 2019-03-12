<?php

namespace common\behaviours;

use common\services\pds\LoginService;
use yii\filters\auth\HttpHeaderAuth;

// TODO: move to api folder?
class PdsBearerAuth extends HttpHeaderAuth
{
    private $pdsLoginService;

    /**
     * {@inheritdoc}
     */
    public $header = 'Authorization';
    /**
     * {@inheritdoc}
     */
    public $pattern = '/^Bearer\s+(.*?)$/';
    /**
     * @var string the HTTP authentication realm
     */
    public $realm = 'api';

    /**
     * AccessTokenFilter constructor.
     * @param array $config
     * @param LoginService $loginService
     */
    public function __construct(array $config = [], LoginService $loginService)
    {
        parent::__construct($config);

        $this->pdsLoginService = $loginService;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get($this->header);

        if ($authHeader !== null) {
            if ($this->pattern !== null) {
                if (preg_match($this->pattern, $authHeader, $matches)) {
                    $authHeader = $matches[1];
                } else {
                    return null;
                }
            }

            // TODO: consider caching response for certain amount of time. There is no need to send consecutive login requests and increase response time
            // Or save token in our db, just like when user logins by username and password
            $identity = $this->pdsLoginService->loginByToken($authHeader);
            if ($identity === null) {
                $this->challenge($response);
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function challenge($response)
    {
        $response->getHeaders()->set('WWW-Authenticate', "Bearer realm=\"{$this->realm}\"");
    }
}