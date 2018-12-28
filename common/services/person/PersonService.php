<?php

namespace common\services\person;

use common\models\link\PersonInstitutionLink;
use common\models\person\Person;
use common\services\TransactionManager;
use common\services\pds\PersonService as PdsService;

class PersonService
{
    private $transactionManager;
    private $pdsService;

    /**
     * PersonService constructor.
     * @param PdsService $pdsService
     * @param TransactionManager $transactionManager
     */
    public function __construct(
        PdsService $pdsService,
        TransactionManager $transactionManager
    )
    {
        $this->transactionManager = $transactionManager;
        $this->pdsService = $pdsService;
    }

    /**
     * @param Person $model
     * @param int $institution_id
     * @return Person
     * @throws \yii\db\Exception
     */
    public function create(Person $model, int $institution_id)
    {
        if (!$model->isNewRecord) {
            throw new \yii\base\InvalidCallException('Model already created');
        }

        $this->transactionManager->execute(function () use ($model, $institution_id) {
//          @TODO uncomment line below, after pds is fixed
//            $model->portal_uid = $this->pdsService->create($model);
            if (!$model->save()) {
                throw new \RuntimeException('Saving error.');
            }

            $link = PersonInstitutionLink::add($model->id, $institution_id);
            $link->save();
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
