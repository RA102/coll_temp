<?php

namespace common\services\organization;

use common\models\link\PersonInstitutionLink;
use common\models\organization\Institution;
use common\models\organization\InstitutionApplication;
use common\models\person\Employee;
use common\services\person\PersonService;
use common\services\TransactionManager;
use frontend\models\SignupForm;

class InstitutionApplicationService
{
    private $transactionManager;
    private $personService;

    public function __construct(
        PersonService $personService,
        TransactionManager $transactionManager
    ) {
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

    /**
     * @param InstitutionApplication $application
     * @throws \yii\db\Exception
     * @TODO use PDS
     */
    public function approve(InstitutionApplication $application)
    {
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

        $link = new PersonInstitutionLink();

        $this->transactionManager->execute(function () use ($person, $application, $link, $institution) {
            $person->save();
            $institution->save();

            $link->person_id = $person->id;
            $link->institution_id = $institution->id;
            $link->save();

            $application->save();
//            $person->portal_uid = $this->personService->create($person);
//            if (!$person->save()) {
//                throw new \RuntimeException('Saving error.');
//            }
        });
    }
}
