<?php

namespace common\services\person;

use common\models\organization\Institution;
use common\models\person\Entrant;
use common\models\person\Person;
use common\models\reception\Commission;
use common\models\ReceptionGroup;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class EntrantService
{
    /**
     * @param Institution $institution
     * @param Commission $commission
     * @return array|Entrant[]
     */
    public function getCommissionEntrants(Institution $institution, Commission $commission)
    {
        $receptionGroupIds = ArrayHelper::getColumn($commission->receptionGroups, 'id');
        return Entrant::find()->joinWith([
            /** @see Person::getPersonInstitutionLinks() */
            'personInstitutionLinks'     => function (ActiveQuery $query) use ($institution) {
                $query->andWhere([
                    'link.person_institution_link.institution_id' => $institution->id,
                ]);
            },
            /** @see Entrant::getEntrantReceptionGroupLinks() */
            'entrantReceptionGroupLinks' => function (ActiveQuery $query) use ($receptionGroupIds) {
                $query->andWhere([
                    'link.entrant_reception_group_link.reception_group_id' => $receptionGroupIds,
                ]);
            },
        ])->all();
    }

    /**
     * @param ReceptionGroup $receptionGroup
     * @param int $education_pay_form
     * @param array $based_classes
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getEntrantsForEntranceExamsReport(
        ReceptionGroup $receptionGroup,
        int $education_pay_form,
        array $based_classes
    ) {
        // NOTE: Use method where to override default filter by entrant type (After enlisting entrant becomes student)
        $entrants = Entrant::find()->where([])->innerJoinWith([
            'admissionApplication',
            'receptionGroup' => function (ActiveQuery $query) use ($receptionGroup) {
                return $query->andWhere(['reception.group.id' => $receptionGroup->id]);
            },
            'receptionExamGrades'
        ], [true, false, true])->all();

        return array_filter($entrants, function (Entrant $entrant) use ($education_pay_form, $based_classes) {
            if (!isset($entrant->admissionApplication)) {
                return false;
            }

            return $entrant->admissionApplication->properties['education_pay_form'] == $education_pay_form &&
                in_array($entrant->admissionApplication->properties['based_classes'], $based_classes);
        });
    }

    /**
     * @param array $receptionGroupIds
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getEntrantsByReceptionGroupIds(array $receptionGroupIds)
    {
        // NOTE: Use method where to override default filter by entrant type (After enlisting entrant becomes student)
        return Entrant::find()->where([])->innerJoinWith([
            'receptionGroup' => function (ActiveQuery $query) use ($receptionGroupIds) {
                return $query->andWhere(['reception.group.id' => $receptionGroupIds]);
            },
        ])->all();
    }
}
