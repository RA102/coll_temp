<?php

namespace common\services\reception;

use common\helpers\ApplicationHelper;
use common\models\handbook\Speciality;
use common\models\reception\AdmissionApplication;
use common\models\reception\Commission;
use yii\db\Expression;

class CompetitionService
{
    /**
     * @param Commission $commission
     * @return array
     */
    public function getCompetitions(Commission $commission)
    {
        $admissionApplications = AdmissionApplication::findAll([
            'commission_id' => $commission->id,
            'status'        => [ApplicationHelper::STATUS_ACCEPTED, ApplicationHelper::STATUS_ENLISTED]
        ]);

        $competitions = [];
        /* @var $specialitiesMap Speciality[] */
        $specialitiesMap = [];
        foreach ($admissionApplications as $admissionApplication) {
            $speciality_id = $admissionApplication->properties['speciality_id'];
            $key = implode(':', [
                $speciality_id,
                $admissionApplication->properties['education_pay_form'],
                $admissionApplication->properties['language'],
                $admissionApplication->properties['education_form'],
                $admissionApplication->properties['based_classes'],
            ]);

            $speciality = $specialitiesMap[$admissionApplication->properties['speciality_id']]
                ?? Speciality::findOne($admissionApplication->properties['speciality_id']);
            $specialitiesMap[$admissionApplication->properties['speciality_id']] = $speciality;

            $competitions[$key]['education_form'] = $admissionApplication->properties['education_form'];
            $competitions[$key]['education_pay_form'] = $admissionApplication->properties['education_pay_form'];
            $competitions[$key]['based_classes'] = $admissionApplication->properties['based_classes'];
            $competitions[$key]['language'] = $admissionApplication->properties['language'];
            $competitions[$key]['speciality'] = $speciality;

            $competitions[$key]['enlisted_count'] = $competitions[$key]['enlisted_count'] ?? 0;
            $competitions[$key]['total_count'] = ($competitions[$key]['total_count'] ?? 0) + 1;

            if ($admissionApplication->isEnlisted()) {
                $competitions[$key]['enlisted_count']++;
            }
        }

        return array_filter($competitions, function (array $competitionData) {
            return $competitionData['total_count'] != $competitionData['enlisted_count'];
        });
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
    public function getAdmissionApplicationsForCompetition(
        Commission $commission,
        int $speciality_id,
        int $education_pay_form,
        string $language,
        int $education_form,
        string $based_classes
    ) {
        $admissionApplications = AdmissionApplication::find()
            ->where([
                'commission_id' => $commission->id,
                'status'        => ApplicationHelper::STATUS_ACCEPTED
            ])->andWhere(new Expression("properties->>'speciality_id' = :speciality_id", [
                ':speciality_id' => $speciality_id
            ]))->andWhere(new Expression("properties->>'education_pay_form' = :education_pay_form", [
                ':education_pay_form' => $education_pay_form
            ]))->andWhere(new Expression("properties->>'language' = :language", [
                ':language' => $language
            ]))->andWhere(new Expression("properties->>'education_form' = :education_form", [
                ':education_form' => $education_form
            ]))->andWhere(new Expression("properties->>'based_classes' = :based_classes", [
                ':based_classes' => $based_classes
            ]))
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

                return $admissionApplication->person->passedReceptionExams($receptionGroup->receptionExams);
            }
        );
    }
}