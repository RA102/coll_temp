<?php

namespace common\services\person;

use common\helpers\PersonCredentialHelper;
use common\models\link\PersonInstitutionLink;
use common\models\person\Person;
use common\models\person\PersonCredential;
use common\services\NotificationService;
use common\services\pds\PersonCredentialService;
use common\services\pds\PersonService as PdsService;
use common\services\TransactionManager;

class PersonService
{
    private $notificationService;
    private $transactionManager;
    private $personCredentialService;
    private $pdsService;

    /**
     * PersonService constructor.
     * @param NotificationService $notificationService
     * @param PersonCredentialService $personCredentialService
     * @param PdsService $pdsService
     * @param TransactionManager $transactionManager
     */
    public function __construct(
        NotificationService $notificationService,
        PersonCredentialService $personCredentialService,
        PdsService $pdsService,
        TransactionManager $transactionManager
    ) {
        $this->notificationService = $notificationService;
        $this->personCredentialService = $personCredentialService;
        $this->transactionManager = $transactionManager;
        $this->pdsService = $pdsService;
    }

    /**
     * @param Person $model
     * @param int $institution_id
     * @param bool $create_identity
     * @param string $identity
     * @param string $credential_type
     * @param string $accessToken
     * @param string $role
     * @return Person
     * @throws \Exception
     */
    public function create(
        Person $model,
        $institution_id,
        $create_identity,
        $identity,
        $credential_type = PersonCredentialHelper::TYPE_EMAIL,
        $accessToken,
        $role
    ) {
        if (!$model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model already created');
        }

        // TODO: Remove. Probably deprecated, pass to transaction manager $model variable instead of $person
        $person = Person::findOne(['iin' => $model->iin]);
        if ($person) {
            if ($person->institution) {
                throw new \Exception('Person is attached to institution');
            }

            $person->setAttributes(array_filter($model->getAttributes(), function ($value) {
                return !is_null($value);
            }));
        } else {
            $person = $model;
        }

        $this->transactionManager->execute(function () use (
            $person,
            $institution_id,
            $create_identity,
            $identity,
            $credential_type,
            $accessToken,
            $role
        ) {
            $pdsPerson = $this->pdsService->create(
                $person,
                $identity,
                $credential_type,
                $create_identity
            );
            $person->portal_uid = $pdsPerson->id;

            if (!$person->save()) {
                if (YII_DEBUG) {
                    $errors = $person->errors;
                    throw new \RuntimeException(reset($errors)[0]);
                }
                throw new \RuntimeException('Saving error.');
            }

            // TODO: add email to contacts
            if ($pdsPerson->is_new && $create_identity) {
                $personCredential = PersonCredential::add($person, $identity);
                $personCredential->save();

                // TODO: send notifications via queue
                $this->notificationService->sendPersonCreatedNotification(
                    $identity,
                    $pdsPerson->validation
                );
            }

            if (!$pdsPerson->is_new && $create_identity) {
                $this->personCredentialService->create(
                    $person->id,
                    $identity,
                    $accessToken,
                    $role
                );
            }

            $link = PersonInstitutionLink::add($person->id, $institution_id);
            $link->save();
        });

        return $person;
    }

    public function update(Person $model)
    {
        if ($model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model not created');
        }

        $this->transactionManager->execute(function () use ($model) {
            $this->pdsService->update($model);
            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }
        });

        return $model;
    }

    public function delete(Person $model)
    {
        if ($model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model not created');
        }

        if ($model->isDeleted()) {
            throw new \yii\base\InvalidCallException('Model is already deleted');
        }

        $this->transactionManager->execute(function () use ($model) {
            $model->delete_ts = date('Y-m-d H:i:s');
            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }
        });

        return $model;
    }

    public function fire(Person $model)
    {
        if ($model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model not created');
        }

        if ($model->isDeleted() || $model->isFired()) {
            throw new \yii\base\InvalidCallException('Not allowed');
        }

        $this->transactionManager->execute(function () use ($model) {
            $model->status = Person::STATUS_FIRED;
            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }
        });

        return $model;
    }
}
