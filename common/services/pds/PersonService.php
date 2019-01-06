<?php

namespace common\services\pds;

use common\models\person\Person;
use common\services\pds\exceptions\PersonAlreadyExistException;
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
     * @param bool $create_identity
     * @param string $identity
     * @param string $credential_type
     * @return int
     * @throws ForbiddenHttpException
     * @throws \Throwable
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function create(
        Person $model,
        bool $create_identity,
        string $identity,
        string $credential_type
    ): int
    {
        if (!empty($model->portal_uid)) {
            throw new ForbiddenHttpException('Person already exists');
        }

        $newPerson = new PdsPersonInterface();
        $newPerson->lastname = $model->lastname;
        $newPerson->middlename = $model->middlename;
        $newPerson->firstname = $model->firstname;
        $newPerson->iin = $model->iin;
        $newPerson->generate_credential = $create_identity;
        $newPerson->indentity = $identity;
        $newPerson->credential_type = $credential_type;
        if ($model->birth_date) {
            $birthDate = new \DateTime($model->birth_date);
            $newPerson->birth_date = $birthDate->format('Y-m-d');
        }

        try {
            $person = $this->createService->create($newPerson);
        } catch (PersonAlreadyExistException $e) {
            $person = $this->searchService->findOne(array_filter($newPerson->getAttributes()));
        }

        return $person->id;
    }

    /**
     * @param Person $model
     * @return PdsPersonInterface
     * @throws ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     * @throws \Throwable
     */
    public function update(Person $model)
    {
        if (empty($model->portal_uid)) {
            throw new ForbiddenHttpException('Person has not `portal_uid`');
        }

        $person = new PdsPersonInterface();
        $person->lastname = $model->lastname;
        $person->middlename = $model->middlename;
        $person->firstname = $model->firstname;
        $person->iin = $model->iin;
        if ($model->birth_date) {
            $birthDate = new \DateTime($model->birth_date);
            $person->birth_date = $birthDate->format('Y-m-d');
        }

        return $this->updateService->update($model->portal_uid, $person);
    }

    /**
     * @param array $query
     * @return null
     * @throws ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     * @throws \Throwable
     */
    public function findAll(array $query)
    {
        return $this->searchService->findAll($query);
    }
}
