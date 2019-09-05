<?php

namespace common\services\reception;

use app\models\link\EntrantReceptionGroupLink;
use common\helpers\ApplicationHelper;
use common\helpers\PersonCredentialHelper;
use common\helpers\PersonTypeHelper;
use common\models\link\StudentGroupLink;
use common\models\link\PersonInstitutionLink;
use common\models\person\Entrant;
use common\models\person\Person;
use common\models\reception\AdmissionApplication;
use common\services\exceptions\DomainException;
use common\services\person\PersonService;
use common\services\TransactionManager;
use frontend\models\forms\AdmissionApplicationForm;
use frontend\models\reception\admission_application\ReceiptForm;

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
     * @param int $commission_id
     * @param int $institution_id
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function create(
        AdmissionApplicationForm $admissionApplicationForm,
        int $commission_id,
        int $institution_id
    ): AdmissionApplication {
        // TODO: add validation of iin and email uniqueness, check existence of similar application
        $admissionApplication = AdmissionApplication::add(
            $commission_id,
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

    public function changeSpeciality(
        int $id,
        AdmissionApplicationForm $admissionApplicationForm
    ): AdmissionApplication {
        $admissionApplication = AdmissionApplication::findOne($id);
        if (!$admissionApplication) {
            throw new \Exception('Not Found');
        }

        $admissionApplication->properties['speciality_id'] = $admissionApplicationForm->speciality_id;
        if (!$admissionApplication->save()) {
            throw new \Exception('Saving Error');
        }

        return $admissionApplication;
    }

    /**
     * @param int $id
     * @param int $status
     * @param Person $user
     * @param int|null $reception_group_id
     * @param string $reason
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function changeStatus(
        int $id,
        int $status,
        Person $user,
        int $reception_group_id = null,
        string $reason = null
    ) {
        if ($status === ApplicationHelper::STATUS_ACCEPTED) {
            if (!$reception_group_id) {
                throw new \Exception('Group must be specified for accepted admission application');
            }
            return $this->accept($id, $user, $reception_group_id);
        }
        if ($status === ApplicationHelper::STATUS_DECLINED) {
            return $this->decline($id, $reason);
        }
        if ($status === ApplicationHelper::STATUS_WITHDRAWN) {
            return $this->withdraw($id, $reason);
        }
        if ($status === ApplicationHelper::STATUS_DELETED) {
            return $this->delete($id);
        }

        throw new \Exception('Not supported status');
    }

    /**
     * @param int $application_id
     * @param Person $user
     * @param int $reception_group_id
     * @return AdmissionApplication
     * @throws \Exception
     */
    protected function accept(int $application_id, Person $user, int $reception_group_id): AdmissionApplication
    {
        $admissionApplication = AdmissionApplication::findOne($application_id);
        if (!$admissionApplication) {
            throw new \Exception('Not Found');
        }
        if ($admissionApplication->status !== ApplicationHelper::STATUS_CREATED && $admissionApplication->status !== ApplicationHelper::STATUS_ACCEPTED) {
            throw new \Exception('Forbidden');
        }
        $admissionApplication->status = ApplicationHelper::STATUS_ACCEPTED;

        if (Entrant::find()->where(['id' => $admissionApplication->person_id])->one() == null) {
            $entrant = Entrant::add(
                null,
                $admissionApplication->properties['firstname'],
                $admissionApplication->properties['lastname'],
                $admissionApplication->properties['middlename'],
                $admissionApplication->properties['iin']
            );
            $entrant->setAttributes($admissionApplication->properties);
        } else {
            $entrant = Entrant::find()->where(['id' => $admissionApplication->person_id])->one();
        }

        $this->transactionManager->execute(function () use (
            $entrant,
            $user,
            &$admissionApplication,
            $reception_group_id
        ) {
            if (Entrant::find()->where(['id' => $admissionApplication->person_id])->one() == null) {
                $person = $this->personService->create(
                    $entrant,
                    $admissionApplication->institution_id,
                    $admissionApplication->properties['email'],
                    PersonCredentialHelper::TYPE_EMAIL,
                    $user->activeAccessToken->token,
                    $user->person_type
                );
            } else {
                $person = Entrant::find()->where(['id' => $admissionApplication->person_id])->one();
            }

            $admissionApplication->person_id = $person->id;
            if (!$admissionApplication->save()) {
                throw new \Exception('Saving error');
            }

            if (EntrantReceptionGroupLink::find()->where(['entrant_id' => $person->id])->one() !== null) {
                EntrantReceptionGroupLink::find()->where(['entrant_id' => $person->id])->one()->delete();
            }
            
            $entrantReceptionGroupLink = EntrantReceptionGroupLink::add(
                $person->id,
                $reception_group_id
            );
            if (!$entrantReceptionGroupLink->save()) {
                throw new \Exception(current($entrantReceptionGroupLink->getFirstErrors()));
            }
        });

        return $admissionApplication;
    }

    /**
     * @param int $id
     * @param string $reason
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function decline(int $id, string $reason): AdmissionApplication
    {
        $admissionApplication = AdmissionApplication::findOne($id);
        if (!$admissionApplication) {
            throw new \Exception('Admission application not found');
        }

        $admissionApplication->status = ApplicationHelper::STATUS_DECLINED;
        $admissionApplication->reason = $reason;
        if (!$admissionApplication->save()) {
            throw new \Exception('Saving error');
        }

        return $admissionApplication;
    }

    /**
     * @param int $id
     * @param string $reason
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function withdraw(int $id, string $reason): AdmissionApplication
    {
        $admissionApplication = AdmissionApplication::findOne($id);
        if (!$admissionApplication) {
            throw new \Exception('Admission application not found');
        }

        $admissionApplication->status = ApplicationHelper::STATUS_WITHDRAWN;
        $admissionApplication->reason = $reason;
        if (!$admissionApplication->save()) {
            throw new \Exception('Saving error');
        }

        return $admissionApplication;
    }

    /**
     * @param int $id
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function delete(int $id): AdmissionApplication
    {
        $admissionApplication = AdmissionApplication::findOne($id);
        if (!$admissionApplication) {
            throw new \Exception('Admission application not found');
        }


        /* TODO: переписать нормально + удалить из pds */
        /*$entrant = Person::find()->where(['id' => $admissionApplication->person_id])->one();
        if ($entrant !== null) {
            $entrantReceptionGroupLink = EntrantReceptionGroupLink::find()->where(['entrant_id' => $admissionApplication->person_id])->one();
            if (!empty($entrantReceptionGroupLink)) {
                $entrantReceptionGroupLink->delete();
            }
            $personInstitutionLink = PersonInstitutionLink::find()->where(['person_id' => $admissionApplication->person_id])->one();
            if (!empty($personInstitutionLink)) {
                $personInstitutionLink->delete();
            }
        }*/

        $admissionApplication->status = ApplicationHelper::STATUS_DELETED;
        $admissionApplication->is_deleted = true;
        $admissionApplication->delete_ts = date("Y-m-d H:i:s");
        $admissionApplication->person_id = null;
   
        if (!$admissionApplication->save()) {
            throw new \Exception('Saving error');
        }

        //$entrant->delete();


        return $admissionApplication;
    }

    /**
     * @param int $id
     * @param int $group_id
     * @return AdmissionApplication
     * @throws \Exception
     */
    public function enlist(int $id, int $group_id): AdmissionApplication
    {
        $admissionApplication = AdmissionApplication::findOne([
            'id'     => $id,
            'status' => ApplicationHelper::STATUS_ACCEPTED
        ]);
        if (!$admissionApplication) {
            throw new \Exception('Admission application not found');
        }

        $admissionApplication->status = ApplicationHelper::STATUS_ENLISTED;
        $entrant = $admissionApplication->person;
        $entrant->type = Person::TYPE_STUDENT;
        $entrant->person_type = PersonTypeHelper::PERSON_TYPE_STUDENT;

        $this->transactionManager->execute(function () use (
            &$admissionApplication,
            &$entrant,
            $group_id
        ) {
            if (!$admissionApplication->save()) {
                throw new \Exception('Saving Error');
            }
            if (!$entrant->save()) {
                throw new \Exception('Saving Error');
            }

            $studentGroupLink = new StudentGroupLink([
                'student_id' => $entrant->id,
                'group_id'   => $group_id
            ]);
            if (!$studentGroupLink->save()) {
                throw new \Exception('Saving Error');
            }
        });

        return $admissionApplication;
    }

    /**
     * @param AdmissionApplication $admissionApplication
     * @param ReceiptForm $receiptForm
     * @return AdmissionApplication
     * @throws DomainException
     */
    public function addReceipt(AdmissionApplication $admissionApplication, ReceiptForm $receiptForm)
    {
        if (!$admissionApplication->isAccepted()) {
            throw new DomainException(
                'Admission application must be accepted',
                'Расписку можно сформировать только для зарегистрированных заявок'
            );
        }
        $admissionApplication->receipt = $receiptForm->getAttributes();
        if (!$admissionApplication->save()) {
            throw new DomainException(
                'Saving Error',
                current($admissionApplication->firstErrors)
            );
        }

        return $admissionApplication;
    }
}