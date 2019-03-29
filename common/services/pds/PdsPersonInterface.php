<?php

namespace common\services\pds;

use common\helpers\PersonCredentialHelper;

class PdsPersonInterface
{
    public $id;
    public $lastname;
    public $middlename;
    public $firstname;
    public $create_ts;
    public $birth_date;
    public $iin;
    public $indentity;
    public $credential_type = PersonCredentialHelper::TYPE_EMAIL;
    public $generate_credential;
    public $validation;
    public $is_new;

    public function getAttributes()
    {
        return get_object_vars($this);
    }
}
