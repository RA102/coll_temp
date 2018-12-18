<?php

namespace common\services\person;

use common\models\person\Person;
use common\models\person\PersonContact;

class PersonContactService
{
    public function getContact(Person $person, $name)
    {
        foreach ($person->personContacts as $personContact) {
            if ($personContact->name == $name) {
                return $personContact;
            }
        }

        return null;
    }

    public function getContactValue(Person $person, $name)
    {
        if (($personContact = $this->getContact($person, $name)) !== null) {
            return $personContact->value;
        }

        return null;
    }

    public function setContactValue(Person $person, $name, $value)
    {
        if (($personContact = $this->getContact($person, $name)) !== null) {
            $personContact->value = $value;
        } else {
            $personContact = PersonContact::add($person, $name, $value);
        }

        $personContact->save();
    }
}