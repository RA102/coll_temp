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

    /**
     * @param Commission $commission
     * @return ReceptionGroup[]
     */
    public function getCommissionReceptionGroups(Commission $commission)
    {
        return ReceptionGroup::findAll(['commission_id' => $commission->id]);
    }

    /**
     * @param int $commission_id
     * @param int $speciality_id
     * @param int $education_form
     * @param string $language
     * @param array $exam_types
     * @return ReceptionGroup|null
     */
    public function findCommissionReceptionGroupByExamType(
        int $commission_id,
        int $speciality_id,
        int $education_form,
        string $language,
        array $exam_types
    ) {
        $receptionGroup = ReceptionGroup::find()
            ->andWhere([
                'speciality_id'                 => $speciality_id,
                'reception.group.commission_id' => $commission_id,
                'education_form'                => $education_form,
                'language'                      => $language
            ])->joinWith([
                'receptionExams' => function (ActiveQuery $query) use ($exam_types) {
                    return $query->andWhere(['reception.exam.type' => $exam_types]);
                }
            ])->one();

        return $receptionGroup;
    }
}