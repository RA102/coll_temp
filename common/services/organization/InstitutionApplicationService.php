<?php

namespace common\services\organization;

use backend\models\forms\ApplicationForm;
use common\helpers\PersonCredentialHelper;
use common\models\organization\Institution;
use common\models\organization\InstitutionApplication;
use common\models\person\Employee;
use common\services\NotificationService;
use common\services\person\PersonService;
use common\services\TransactionManager;
use frontend\models\SignupForm;

class InstitutionApplicationService
{
    private $notificationService;
    private $transactionManager;
    private $personService;

    public function __construct(
        NotificationService $notificationService,
        PersonService $personService,
        TransactionManager $transactionManager
    ) {
        $this->notificationService = $notificationService;
        $this->transactionManager = $transactionManager;
        $this->personService = $personService;
    }

    public function create(SignupForm $form)
    {
        $model = new InstitutionApplication();
        $model->setAttributes($form->attributes);
        $model->street = $form->street_id;
        $model->type_id = end($form->type_ids) ?? null;
        $model->city_id = end($form->city_ids) ?? null;
        $model->status = InstitutionApplication::STATUS_NEW;
        $model->save();
    }

    public function update(InstitutionApplication $application, ApplicationForm $form)
    {
        $application->setAttributes($form->attributes);
        $application->type_id = end($form->type_ids);
        $application->city_id = end($form->city_ids);
        $application->save();
    }

    /**
     * Create institution and superadmin user
     * @param InstitutionApplication $application
     * @throws \yii\db\Exception
     * @TODO use PDS
     */
    public function approve(InstitutionApplication $application)
    {
        $this->guardNewRecord($application);
        $this->guardProcessed($application);

        $application->status = InstitutionApplication::STATUS_APPROVED;

        $person = Employee::add(
            null,
            $application->firstname,
            $application->lastname,
            $application->middlename,
            $application->iin
        );
        $person->birth_date = $application->birth_date;

        $institution = Institution::add(
            $application->street,
            $application->city_id,
            $application->type_id,
            $application->house_number,
            $application->educational_form_id,
            $application->organizational_legal_form_id
        );

        $this->transactionManager->execute(function () use ($person, $application, $institution) {
            $institution->save();
            $application->save();

            $this->personService->create(
                $person,
                $institution->id,
                true,
                $application->email,
                PersonCredentialHelper::TYPE_EMAIL
            );
        });

        $this->notificationService->sendRegistrationCompletedNotification(
            $application->email
        );
    }

    public function reject(InstitutionApplication $application)
    {
        $this->guardNewRecord($application);
        $this->guardProcessed($application);

        $application->status = InstitutionApplication::STATUS_REJECTED;
        $application->save();
    }

    private function guardNewRecord(InstitutionApplication $model)
    {
        if ($model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model not created');
        }
    }

    private function guardProcessed(InstitutionApplication $model)
    {
        if (!$model->isNew()) {
            throw new \yii\base\InvalidCallException('Model is already processed');
        }
    }
}
