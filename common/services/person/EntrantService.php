<?php

namespace common\services\person;

use common\models\organization\Institution;
use common\models\person\Entrant;
use common\models\person\Person;

class EntrantService
{
    public function getEntrants(Institution $institution)
    {
        return Entrant::find()->joinWith([
            /** @see Person::getPersonInstitutionLinks() */
            'personInstitutionLinks' => function (\yii\db\ActiveQuery $query) use ($institution) {
                $query->andWhere([
                    'link.person_institution_link.institution_id' => $institution->id,
                ]);
            },
        ])->all();
    }
}
