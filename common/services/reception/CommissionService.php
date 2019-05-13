<?php

namespace common\services\reception;

use common\models\link\CommissionMemberLink;
use common\models\organization\Institution;
use common\models\person\Person;
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
        return Commission::find()
            ->andWhere([
                Commission::tableName() . '.institution_id' => $institution->id,
                Commission::tableName() . '.delete_ts' => null,
            ])
            ->all();
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
                Commission::tableName() . '.delete_ts' => null
            ])
            ->limit(1)
            ->one();
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
                Commission::tableName() . '.delete_ts' => null,
            ])
            ->limit(1)
            ->one();
    }

    public function closeCommission(Commission $commission)
    {
        $commission->status = Commission::STATUS_CLOSED;
        $commission->save();

        return $commission;
    }

    public function deleteCommission(Commission $commission)
    {
//        foreach ($commission->institutionDisciplines as $institutionDiscipline) {
//            /** @see Commission::getInstitutionDisciplines() */
//            $commission->unlink('institutionDisciplines', $institutionDiscipline, true);
//        }

        $commission->delete_ts = date('Y-m-d H:i:s');
        $commission->save();

        return $commission;
    }

    /**
     * @param Commission $commission
     * @param array $roles
     * @return Person[]
     */
    public function getCommissionMembers(Commission $commission, array $roles)
    {
        $commissionMemberLinks = CommissionMemberLink::find()->joinWith('member')->where([
            'commission_id' => $commission->id,
            'role'          => $roles
        ])->all();

        return array_map(function (CommissionMemberLink $commissionMemberLink) {
            return $commissionMemberLink->member;
        }, $commissionMemberLinks);
    }
}