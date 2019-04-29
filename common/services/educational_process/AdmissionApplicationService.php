<?php

namespace common\services\educational_process;

use common\helpers\ApplicationHelper;
use common\helpers\PersonCredentialHelper;
use common\models\educational_process\AdmissionApplication;
use common\models\person\Entrant;
use common\models\person\Person;
use common\services\person\PersonService;
use common\services\TransactionManager;
use frontend\models\forms\AdmissionApplicationForm;

class AdmissionApplicationService
{
    public $personService;
    public $transactionManager;

    /**
     * AdmissionApplicationService constructor.
     * @param PersonService $personService
     */
    public function __construct(PersonService $personService, TransactionManager $transactionManager)
    {
        $this->personService = $personService;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param AdmissionApplicationForm $admissionApplicationForm
     * @param int $institution_id
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function create(
        AdmissionApplicationForm $admissionApplicationForm,
        int $institution_id
    ): AdmissionApplication {
        $admissionApplication = AdmissionApplication::add(
            $institution_id,
            $admissionApplicationForm->getAttributes()
        );

        if (!$admissionApplication->save()) {
            throw new \Exception('Saving Error');
        }

        return $admissionApplication;
    }

    /**
     * @param int $id
     * @param AdmissionApplicationForm $admissionApplicationForm
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function update(
        int $id,
        AdmissionApplicationForm $admissionApplicationForm
    ): AdmissionApplication {
        $admissionApplication = AdmissionApplication::findOne($id);
        if (!$admissionApplication) {
            throw new \Exception('Not Found');
        }

        $admissionApplication->properties = $admissionApplicationForm->getAttributes();
        if (!$admissionApplication->save()) {
            throw new \Exception('Saving Error');
        }

        return $admissionApplication;
    }

    /**
     * @param int $application_id
     * @param Person $user
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function accept(int $application_id, Person $user): AdmissionApplication
    {
        $admissionApplication = AdmissionApplication::findOne($application_id);
        if (!$admissionApplication) {
            throw new \Exception('Not Found');
        }
        if ($admissionApplication->status !== ApplicationHelper::STATUS_CREATED) {
            throw new \Exception('Forbidden');
        }
        $admissionApplication->status = ApplicationHelper::STATUS_ACCEPTED;

        $entrant = Entrant::add(
            null,
            $admissionApplication->properties['firstname'],
            $admissionApplication->properties['lastname'],
            $admissionApplication->properties['middlename'],
            $admissionApplication->properties['iin']
        );
        $entrant->setAttributes($admissionApplication->properties);

        $this->transactionManager->execute(function () use (
            $entrant,
            $user,
            &$admissionApplication
        ) {
            $person = $this->personService->create(
                $entrant,
                $admissionApplication->institution_id,
                true,
                $admissionApplication->properties['email'],
                PersonCredentialHelper::TYPE_EMAIL,
                $user->activeAccessToken->token,
                $user->person_type
            );

            $admissionApplication->person_id = $person->id;
            if (!$admissionApplication->save()) {
                throw new \Exception('Saving error');
            }
        });

        return $admissionApplication;
    }
}