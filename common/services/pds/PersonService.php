<?php

namespace common\services\pds;

use common\models\person\Person;
use yii\web\ForbiddenHttpException;

class PersonService
{
    private $createService;
    private $updateService;
    private $searchService;

    public function __construct(
        PersonCreateService $createService,
        PersonUpdateService $updateService,
        PersonSearchService $searchService
    )
    {
        $this->createService = $createService;
        $this->updateService = $updateService;
        $this->searchService = $searchService;
    }

    /**
     * @param Person $model
     * @return PdsPersonInterface
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function create(Person $model)
    {
        if (!empty($model->portal_uid)) {
            throw new ForbiddenHttpException('Person already exists');
        }

        $person = new PdsPersonInterface();
        $person->lastname = $model->lastname;
        $person->middlename = $model->middlename;
        $person->firstname = $model->firstname;
        $person->birth_date = $model->birth_date;
        $person->iin = $model->iin;

        return $this->createService->create($person);
    }

    /**
     * @param Person $model
     * @return PdsPersonInterface
     * @throws ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function update(Person $model)
    {
        if (!empty($model->portal_uid)) {
            throw new ForbiddenHttpException('Person has not `portal_uid`');
        }

        $person = new PdsPersonInterface();
        $person->lastname = $model->lastname;
        $person->middlename = $model->middlename;
        $person->firstname = $model->firstname;
        $person->birth_date = $model->birth_date;
        $person->iin = $model->iin;

        return $this->updateService->update($model->portal_uid, $person);
    }

    /**
     * @param array $query
     * @return null
     * @throws ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function findAll(array $query)
    {
        return $this->searchService->findAll($query);
    }
}
