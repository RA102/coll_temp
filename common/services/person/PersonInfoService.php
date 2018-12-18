<?php

namespace common\services\person;

use common\models\person\Person;
use common\models\person\PersonInfo;

class PersonInfoService
{
    public function getInfo(Person $person, $name)
    {
        foreach ($person->personInfos as $personInfo) {
            if ($personInfo->name == $name) {
                return $personInfo;
            }
        }

        return null;
    }

    public function getInfoValue(Person $person, $name)
    {
        if (($personInfo = $this->getInfo($person, $name)) !== null) {
            return $personInfo->value;
        }

        return null;
    }

    public function setInfoValue(Person $person, $name, $value)
    {
        if (($personInfo = $this->getInfo($person, $name)) !== null) {
            $personInfo->value = $value;
        } else {
            $personInfo = PersonInfo::add($person, $name, $value);
        }

        $personInfo->save();
    }
}