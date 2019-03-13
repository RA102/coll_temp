<?php

namespace common\gateways\pds\dto;

/**
 * Class PersonResponse
 * @package common\gateways\pds\dto
 */
class PersonResponse
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $lastname;

    /**
     * @var string
     */
    public $middlename;

    /**
     * @var string
     */
    public $firstname;

    /**
     * ISO date time
     * @var string
     */
    public $create_ts;

    /**
     * ISO date
     * @var string
     */
    public $birth_date;

    /**
     * @var string | null
     */
    public $iin;

    /**
     * @var PersonCredentialResponse
     */
    public $cred;
}