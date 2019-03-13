<?php

namespace common\gateways\pds\dto;

/**
 * Class LoginResponse
 * @package common\gateways\pds\dto
 */
class LoginResponse
{
    /**
     * @var string
     */
    public $token;

    /**
     * @var PersonResponse
     */
    public $person;

    /**
     * @var boolean
     */
    public $is_temporary;

    /**
     * @var string|null
     */
    public $hash;

    /**
     * @var string|null
     */
    public $cert;

    /**
     * @var boolean
     */
    public $by_code;

    /**
     * @var string|null
     */
    public $auth_code;

    /**
     * @var string|null
     */
    public $vToken;

    /**
     * @var string|null
     */
    public $authToken;
}