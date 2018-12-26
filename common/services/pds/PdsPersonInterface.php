<?php

namespace common\services\pds;


class PdsPersonInterface
{
    public $id;
    public $lastname;
    public $middlename;
    public $firstname;
    public $create_ts;
    public $birth_date;
    public $iin;

    public function getAttributes()
    {
        return get_object_vars($this);
    }
}
