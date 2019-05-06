<?php

namespace common\services\person;

use common\models\organization\Institution;
use common\models\person\Entrant;
use common\models\person\Person;
use common\models\reception\Commission;
use yii\helpers\ArrayHelper;

class EntrantService
{
    public function getCommissionEntrants(Institution $institution, Commission $commission)
    {
        $receptionGroupIds = ArrayHelper::getColumn($commission->receptionGroups, 'id');
        return Entrant::find()->joinWith([
            /** @see Person::getPersonInstitutionLinks() */
            'personInstitutionLinks' => function (\yii\db\ActiveQuery $query) use ($institution) {
                $query->andWhere([
                    'link.person_institution_link.institution_id' => $institution->id,
                ]);
            },
            /** @see Entrant::getEntrantReceptionGroupLinks() */
            'entrantReceptionGroupLinks' => function (\yii\db\ActiveQuery $query) use ($receptionGroupIds) {
                $query->andWhere([
                    'link.entrant_reception_group_link.reception_group_id' => $receptionGroupIds,
                ]);
            },
        ])->all();
    }
}
