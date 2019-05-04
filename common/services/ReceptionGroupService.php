<?php

namespace common\services;

use common\models\organization\Institution;
use common\models\reception\Commission;
use common\models\ReceptionGroup;
use yii\db\ActiveQuery;

class ReceptionGroupService
{
    /**
     * @param Institution $institution
     * @param $id
     * @return array|ReceptionGroup
     */
    public function getInstitutionReceptionGroup(Institution $institution, $id)
    {
        return ReceptionGroup::find()
            ->joinWith([
                /** @see ReceptionGroup::getCommission() */
                'commission' => function (ActiveQuery $query) use ($institution) {
                    return $query->andWhere([
                        Commission::tableName() . '.institution_id' => $institution->id,
                    ]);
                }
            ])
            ->andWhere([
                ReceptionGroup::tableName() . '.id' => $id,
            ])
            ->one();
    }
}