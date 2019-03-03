<?php

namespace common\gateways\pds\dto;

class PersonCredentialResponse
{

    /**
     * @var string|null
     */
    public $create_ts;

    /**
     * @var string|null
     */
    public $auth_ts;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $person_id;

    /**
     * @var integer
     */
    public $status;

    /**
     * @var string
     */
    public $indentity;

    /**
     * @var string
     */
    public $validation_clear;

    /**
     * @var string|null
     */
    public $activation_code;

    /**
     * @var integer
     */
    public $enc_type;

    /**
     * @var boolean|integer
     */
    public $is_deleted;

}