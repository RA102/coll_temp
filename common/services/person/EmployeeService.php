<?php

namespace common\services\person;

use common\models\organization\Institution;
use common\models\person\Employee;
use common\models\person\Person;

class EmployeeService
{
    public function getTeachers(Institution $institution)
    {
        return Employee::find()->joinWith([
            /** @see Person::getPersonInstitutionLinks() */
            'personInstitutionLinks' => function (\yii\db\ActiveQuery $query) use ($institution) {
                $query->andWhere([
                    'link.person_institution_link.institution_id' => $institution->id,
                ]);
            },
        ])->all();
    }

    public function getTeachersQuery(Institution $institution)
    {
        return Employee::find()->joinWith([
            /** @see Person::getPersonInstitutionLinks() */
            'personInstitutionLinks' => function (\yii\db\ActiveQuery $query) use ($institution) {
                $query->andWhere([
                    'link.person_institution_link.institution_id' => $institution->id,
                ]);
            },
        ]);
    }

}
