<?php

namespace common\services\person;

use common\models\person\Person;
use common\models\person\PersonLocation;

class PersonLocationService
{
    public function getLocation(Person $person, $type)
    {
        /** @var PersonLocation $location */
        $location = $person->getPersonLocations()->where([
            'type' => $type
        ])->one();

        return $location;
    }

    public function setLocation(Person $person, PersonLocation $location)
    {
        $location->person_id = $person->id;

        $location->save();
    }
}