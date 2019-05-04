<?php

namespace common\services\reception;

use common\helpers\ApplicationHelper;
use common\models\educational_process\AdmissionApplication;
use common\models\handbook\Speciality;

class CompetitionService
{
    /**
     * @return array
     */
    public function getCompetitions()
    {
        $admissionApplications = AdmissionApplication::findAll([
            'type'   => ApplicationHelper::APPLICATION_TYPE_ADMISSION,
            'status' => [ApplicationHelper::STATUS_ACCEPTED, ApplicationHelper::STATUS_ENLISTED]
        ]);

        $competitions = [];
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
            $competitions[$key]['total_count'] = ($competitions[$key]['total_count'] ?? 0) + 1;
            $competitions[$key]['enlisted_count'] = $competitions[$key]['enlisted_count'] ?? 0;

            $specialitiesMap[$speciality_id] = $specialitiesMap[$speciality_id] ?? Speciality::findOne($speciality_id);
            if ($admissionApplication->isEnlisted()) {
                $competitions[$key]['enlisted_count']++;
            }
            $competitions[$key]['specialityName'] = $specialitiesMap[$speciality_id]->caption_current;
            $competitions[$key] = array_merge($competitions[$key], $competitionKeyParts);
        }

        return array_filter($competitions, function (array $competitionData) {
            return $competitionData['total_count'] != $competitionData['enlisted_count'];
        });
    }

    /**
     * @param int $speciality_id
     * @param int $education_pay_form
     * @param string $language
     * @param int $education_form
     * @param string $based_classes
     * @return AdmissionApplication[]
     */
    public function getAdmissionApplicationsForCompetition(
        int $speciality_id,
        int $education_pay_form,
        string $language,
        int $education_form,
        string $based_classes
    ) {
        $admissionApplications = AdmissionApplication::findAll([
            'type'   => ApplicationHelper::APPLICATION_TYPE_ADMISSION,
            'status' => ApplicationHelper::STATUS_ACCEPTED
        ]);

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

                return $admissionApplication->properties['speciality_id'] == $speciality_id
                    && $admissionApplication->properties['education_pay_form'] == $education_pay_form
                    && $admissionApplication->properties['language'] == $language
                    && $admissionApplication->properties['education_form'] == $education_form
                    && $admissionApplication->properties['based_classes'] == $based_classes
                    && $admissionApplication->person->passedReceptionExams($receptionGroup->receptionExams);
            }
        );
    }
}