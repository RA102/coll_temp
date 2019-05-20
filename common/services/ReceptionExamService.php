<?php

namespace common\services;

use common\models\organization\Institution;
use common\models\reception\Commission;
use common\models\ReceptionExam;
use common\models\ReceptionGroup;
use yii\db\ActiveQuery;

class ReceptionExamService
{
    /**
     * @param $id
     * @param Commission|null $commission
     * @param Institution|null $institution
     * @return array|ReceptionGroup
     */
    public function get($id, Commission $commission = null, Institution $institution = null)
    {
        return ReceptionExam::find()
            ->joinWith([
                /** @see ReceptionExam::getCommission() */
                'commission' => function (ActiveQuery $query) use ($commission, $institution) {
                    if ($commission) {
                        $query->andWhere([
                            Commission::tableName() . '.id' => $commission->id,
                        ]);
                    }
                    return $query->joinWith([
                        /** @see Commission::getInstitution() */
                        'institution' => function (ActiveQuery $query) use ($institution) {
                            if ($institution) {
                                $query->andWhere([
                                    Institution::tableName() . '.id' => $institution->id,
                                ]);
                            }
                            return $query;
                        }
                    ]);
                }
            ])
            ->andWhere([
                ReceptionExam::tableName() . '.id' => $id,
            ])
            ->one();
    }
}