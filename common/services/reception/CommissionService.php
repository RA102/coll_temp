<?php

namespace common\services\reception;

use common\models\organization\Institution;
use common\models\reception\Commission;
use yii\db\ActiveRecord;

class CommissionService
{
    public function getInstitutionCommissions(Institution $institution)
    {
        return Commission::find()->andWhere([
            Commission::tableName() . '.institution_id' => $institution->id,
        ])->all();
    }

    /**
     * @param Institution $institution
     * @return array|null|ActiveRecord|Commission
     */
    public function getActiveInstitutionCommission(Institution $institution)
    {
        return Commission::find()
            ->andWhere([
                Commission::tableName() . '.institution_id' => $institution->id,
                Commission::tableName() . '.status' => Commission::STATUS_ACTIVE,
            ])->one();
    }

    public function getInstitutionCommission(Institution $institution, $id)
    {
        return Commission::find()
            ->andWhere([
                Commission::tableName() . '.id' => $id,
                Commission::tableName() . '.institution_id' => $institution->id,
            ])->one();
    }

    public function closeCommission(Commission $commission)
    {
        $commission->status = Commission::STATUS_CLOSED;
        $commission->save();

        return $commission;
    }

    public function deleteCommission(Commission $commission)
    {
        $commission->delete();

        return $commission;
    }
}