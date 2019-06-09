<?php

namespace common\services\pds;

use common\gateways\pds\PdsGateway;
use common\models\person\Person;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class PersonSearchService
{
    protected $pdsGateway;

    /**
     * PersonCreateService constructor.
     * @param PdsGateway $pdsGateway
     */
    public function __construct(PdsGateway $pdsGateway)
    {
        $this->pdsGateway = $pdsGateway;
    }

    /**
     * @param array $query
     * @return PdsPersonInterface|null
     * @throws ForbiddenHttpException
     * @throws UnauthorizedHttpException
     * @throws \Throwable
     */
    public function findOne(array $query)
    {
        $userToken = $this->getAccessToken();
        $user = $this->getUser();

        $persons = $this->findByID($query, $userToken->token, $user->person_type);
        if (!empty($persons)) {
            var_dump($query);
            echo 'by id';
            die();

            return $this->getPersonObject($persons[0], false);
        }

        $persons = $this->findByIIN($query, $userToken->token, $user->person_type);
        if (!empty($persons)) {
            var_dump($query);
            echo 'by iin';
            die();

            return $this->getPersonObject($persons[0], false);
        }

        $persons = $this->findBy($query, $userToken->token, $user->person_type);
        if (!empty($persons)) {
            var_dump($query);
            echo 'by query';
            die();

            return $this->getPersonObject($persons[0], false);
        }

        return null;
    }

    protected function getPersonObject(array $personData, bool $is_new): PdsPersonInterface
    {
        $model = new PdsPersonInterface();
        $model->id = $personData['id'];
        $model->lastname = $personData['lastname'];
        $model->middlename = $personData['middlename'];
        $model->firstname = $personData['firstname'];
        $model->create_ts = $personData['create_ts'];
        $model->birth_date = $personData['birth_date'];
        $model->iin = $personData['iin'];
        $model->validation = $personData['validation'] ?? null;
        $model->is_new = $is_new;

        return $model;
    }

    /**
     * @return Person
     * @throws UnauthorizedHttpException
     * @throws \Throwable
     */
    protected function getUser()
    {
        if (\Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('User has not authorized');
        }

        return \Yii::$app->user->getIdentity();
    }

    /**
     * @return \common\models\person\AccessToken
     * @throws ForbiddenHttpException
     * @throws UnauthorizedHttpException
     * @throws \Throwable
     */
    protected function getAccessToken()
    {
        $user = $this->getUser();

        $accessToken = $user->activeAccessToken;
        if (!$accessToken) {
            throw new ForbiddenHttpException('User not allowed to do action');
        }

        return $accessToken;
    }

    /**
     * @return string
     * @throws UnauthorizedHttpException
     * @throws \Throwable
     */
    protected function getRole()
    {
        return $this->getUser()->person_type;
    }

    /**
     * @param array $query
     * @param string $token
     * @param string $role
     * @return mixed
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    private function findByID(array $query, string $token, string $role)
    {
        if (!isset($query['id'])) {
            return null;
        }

        $data = $this->pdsGateway->search(['id' => $query['id']], $token, $role);
        return Json::decode($data);
    }

    /**
     * @param array $query
     * @param string $token
     * @param string $role
     * @return mixed
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    private function findByIIN(array $query, string $token, string $role)
    {
        if (!isset($query['iin'])) {
            return null;
        }

        $data = $this->pdsGateway->search(['iin' => $query['iin']], $token, $role);
        return Json::decode($data);
    }

    /**
     * @param array $query
     * @param string $token
     * @param string $role
     * @return mixed
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    private function findBy(array $query, string $token, string $role)
    {
        if (empty($query)) {
            return null;
        }

        $data = $this->pdsGateway->search($query, $token, $role);
        return Json::decode($data);
    }
}
