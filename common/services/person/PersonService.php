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
    )
    {
        $this->notificationService = $notificationService;
        $this->personCredentialService = $personCredentialService;
        $this->transactionManager = $transactionManager;
        $this->pdsService = $pdsService;
    }

    /**
     * @param Person $model
     * @param int $institution_id
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
        $identity,
        $credential_type = PersonCredentialHelper::TYPE_EMAIL,
        $accessToken,
        $role
    )
    {
        if (!$model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model already created');
        }

        // TODO: Remove. Probably deprecated, pass to transaction manager $model variable instead of $person
        $person = Person::findOne(['iin' => $model->iin]);
        if ($person) {
            /*if ($person->institution) {
                throw new \Exception(\Yii::t('app', 'Person is attached to institution'));
            }*/

            $person->setAttributes(array_filter($model->getAttributes(), function ($value) {
                return !is_null($value);
            }));
        } else {
            $person = $model;
        }

        $this->transactionManager->execute(function () use (
            $person,
            $institution_id,
            $identity,
            $credential_type,
            $accessToken,
            $role
        ) {
            $pdsPerson = $this->pdsService->create(
                $person,
                $identity,
                $credential_type
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
            if (!empty($identity)) {
                $this->personCredentialService->create(
                    $person->id,
                    $identity,
                    $accessToken,
                    $role
                );

                $personCredential = PersonCredential::add($person, $identity);
                $personCredential->save();

                // TODO: send notifications via queue
                $this->notificationService->sendPersonCreatedNotification(
                    $identity,
                    $pdsPerson->validation
                );
            }

            $link = PersonInstitutionLink::add($person->id, $institution_id, $person->is_pluralist);
            $link->save();
        });

        return $person;
    }

    public function update(Person $model, $institution_id)
    {
        if ($model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model not created');
        }

        $this->transactionManager->execute(function () use ($model, $institution_id) {
            $this->pdsService->update($model);
            $model->setDeleteStatus();

            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }

            if ($model->institution->id !== $institution_id) {
                PersonInstitutionLink::updateAll(['is_deleted' => true], ['person_id' => $model->id, 'is_pluralist' => null]);
                $link = PersonInstitutionLink::findOne(['person_id' => $model->id, 'institution_id' => $institution_id]);

                if ($link) {
                    $link->activate();
                } else {
                    $link = PersonInstitutionLink::add($model->id, $institution_id);
                }
                if (!$link->save()) {
                    throw new \RuntimeException('Saving error.');
                }

                /*PersonInstitutionLink::updateAll(['is_deleted' => true], ['person_id' => $model->id]);
                $link = PersonInstitutionLink::findOne(['person_id' => $model->id, 'institution_id' => $model->institution->id, 'is_pluralist' => null]);

                if ($link) {
                    if ($link->is_deleted == true) {
                        $link->activate();
                    }
                    $link->institution_id = $institution_id;

                    if (!$link->save()) {
                        throw new \RuntimeException('Saving error.');
                    }                
                } else {
                    $link = PersonInstitutionLink::add($model->id, $institution_id);
                }
                if (!$link->save()) {
                    throw new \RuntimeException('Saving error.');
                }*/
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
            $model->status = Person::STATUS_DELETED;
            if (!$model->save()) {
                throw new \RuntimeException(json_encode($model->errors));
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
                throw new \RuntimeException(json_encode($model->errors));
            }
        });

        return $model;
    }

    public function revert(Person $model)
    {
        if ($model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model not created');
        }

        $this->transactionManager->execute(function () use ($model) {
            $model->status = Person::STATUS_ACTIVE;
            $model->delete_ts = null;
            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }
        });

        return $model;
    }

    public function changeType(Person $model, $targetType)
    {
        $this->transactionManager->execute(function () use ($model, $targetType) {
            $model->type = $targetType;
            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }
        });

        return $model;
    }
}
