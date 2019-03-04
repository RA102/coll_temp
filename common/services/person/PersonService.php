<?php

namespace common\services\person;

use common\models\link\PersonInstitutionLink;
use common\models\person\Person;
use common\models\person\PersonCredential;
use common\services\NotificationService;
use common\services\pds\PersonService as PdsService;
use common\services\TransactionManager;

class PersonService
{
    private $notificationService;
    private $transactionManager;
    private $pdsService;

    /**
     * PersonService constructor.
     * @param NotificationService $notificationService
     * @param PdsService $pdsService
     * @param TransactionManager $transactionManager
     */
    public function __construct(
        NotificationService $notificationService,
        PdsService $pdsService,
        TransactionManager $transactionManager
    ) {
        $this->notificationService = $notificationService;
        $this->transactionManager = $transactionManager;
        $this->pdsService = $pdsService;
    }

    /**
     * @param Person $model
     * @param int $institution_id
     * @param bool $create_identity
     * @param string $identity
     * @param string $credential_type
     * @return Person
     * @throws \yii\db\Exception
     */
    public function create(
        Person $model,
        $institution_id,
        $create_identity,
        $identity,
        $credential_type
    ) {
        if (!$model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model already created');
        }

        $this->transactionManager->execute(function () use (
            $model,
            $institution_id,
            $create_identity,
            $identity,
            $credential_type
        ) {
            $pdsPerson = $this->pdsService->create(
                $model,
                $identity,
                $credential_type,
                $create_identity
            );
            $model->portal_uid = $pdsPerson->id;

            if (!$model->save()) {
                if (YII_DEBUG) {
                    $errors = $model->errors;
                    throw new \RuntimeException(reset($errors)[0]);
                }
                throw new \RuntimeException('Saving error.');
            }

            // TODO: add email in contacts
            if ($create_identity) {
                $personCredential = PersonCredential::add($model, $identity);
                $personCredential->save();
            }
            $link = PersonInstitutionLink::add($model->id, $institution_id);
            $link->save();

            // TODO: send notifications via queue
            $this->notificationService->sendPersonCreatedNotification(
                $identity,
                $pdsPerson->validation
            );
        });

        return $model;
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
