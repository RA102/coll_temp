<?php

namespace common\services\reception;

use common\helpers\ApplicationHelper;
use common\models\handbook\Speciality;
use common\models\reception\AdmissionApplication;
use common\models\reception\Commission;
use yii\db\ActiveQuery;
use yii\db\Expression;

class RatingService
{
    public function getRatings(Commission $commission)
    {
        $admissionApplications = AdmissionApplication::findAll([
            'type' => ApplicationHelper::APPLICATION_TYPE_ADMISSION,
            'commission_id' => $commission->id,
        ]);

        $ratings = [];
        /* @var $specialitiesMap Speciality[] */
        $specialitiesMap = [];
        foreach ($admissionApplications as $admissionApplication) {
            $speciality_id = $admissionApplication->properties['speciality_id'];
            $columnNames = [
                'speciality_id',
                'education_pay_form',
                'language',
                'education_form',
                'based_classes'
            ];
            $competitionKeyParts = [];
            foreach ($columnNames as $columnName) {
                $competitionKeyParts[$columnName] = $admissionApplication->properties[$columnName];
            }
            $key = implode(':', $competitionKeyParts);
            if (!isset($ratings[$key])) {
                $ratings[$key] = [];
            }
            $ratings[$key]['total_count'] = ($ratings[$key]['total_count'] ?? 0) + 1;
            $ratings[$key]['enlisted_count'] = $ratings[$key]['enlisted_count'] ?? 0;

            $specialitiesMap[$speciality_id] = $specialitiesMap[$speciality_id] ?? Speciality::findOne($speciality_id);

            $ratings[$key]['specialityName'] = $specialitiesMap[$speciality_id]->caption_current;
            $ratings[$key] = array_merge($ratings[$key], $competitionKeyParts);
        }

        return $ratings;
    }

    /**
     * @param Commission $commission
     * @param int $speciality_id
     * @param int $education_pay_form
     * @param string $language
     * @param int $education_form
     * @param string $based_classes
     * @return AdmissionApplication[]
     */
    public function getAdmissionApplicationsForRating(
        Commission $commission,
        int $speciality_id,
        int $education_pay_form,
        string $language,
        int $education_form,
        string $based_classes
    )
    {
        $admissionApplications = AdmissionApplication::find()
            ->andWhere([
                AdmissionApplication::tableName() . '.type' => ApplicationHelper::APPLICATION_TYPE_ADMISSION,
                'commission_id' => $commission->id,
            ])
            ->andWhere(new Expression("properties @> '{\"speciality_id\": \"{$speciality_id}\"}'"))
            ->andWhere(new Expression("properties @> '{\"education_pay_form\": \"{$education_pay_form}\"}'"))
            ->andWhere(new Expression("properties @> '{\"language\": \"{$language}\"}'"))
            ->andWhere(new Expression("properties @> '{\"education_form\": \"{$education_form}\"}'"))
            ->andWhere(new Expression("properties @> '{\"based_classes\": \"{$based_classes}\"}'"))
            ->with([
                /** @see AdmissionApplication::getPerson() */
                'person' => function (ActiveQuery $query) {
                    return $query->with([
                        /** @see \common\models\person\Entrant::getReceptionGroup() */
                        'receptionGroup',
//                        /** @see \common\models\person\Entrant::getReceptionExamGrades() */
//                        'receptionExamGrades',
                    ]);
                }
            ])
            ->all();

        return array_filter(
            $admissionApplications,
            function (AdmissionApplication $admissionApplication) use (
                $speciality_id,
                $education_pay_form,
                $language,
                $education_form,
                $based_classes
            ) {
                $receptionGroup = $admissionApplication->person->receptionGroup;
                if (!$receptionGroup) {
                    return false;
                }
                return true;
            }
        );
    }
}