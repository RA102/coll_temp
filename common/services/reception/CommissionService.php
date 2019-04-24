<?php

namespace common\services\reception;

use common\models\organization\Institution;
use common\models\reception\Commission;
use yii\db\ActiveRecord;

class CommissionService
{
    /**
     * @param Institution $institution
     * @return array|ActiveRecord[]|Commission[]
     */
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

    /**
     * @param Institution $institution
     * @param $id
     * @return array|null|ActiveRecord|Commission
     */
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
        foreach ($commission->institutionDisciplines as $institutionDiscipline) {
            /** @see Commission::getInstitutionDisciplines() */
            $commission->unlink('institutionDisciplines', $institutionDiscipline, true);
        }

        $commission->delete();

        return $commission;
    }
}