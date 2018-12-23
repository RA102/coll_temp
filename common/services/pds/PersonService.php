<?php

namespace common\services\pds;

use common\models\person\Person;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class PersonService
{
    /**
     * @param Person $person
     * @return null
     * @throws ForbiddenHttpException
     * @throws UnauthorizedHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function find(Person $person)
    {
        try {
            $userToken = $this->getAccessToken();
            $personData = $this->getPdsPersonData($person, $userToken);
            return $this->getPersonObject($personData);
        } catch (\yii\web\UnprocessableEntityHttpException $e) {
            return null;
        }
    }

    /**
     * @param Person $person
     * @param string $token
     * @return mixed
     * @throws \Exception
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    private function getPdsPersonData(Person $person, string $token)
    {
        $connection = curl_init();
        if (!$connection) {
            throw new \Exception('Could not connect to remote server');
        }

        curl_setopt_array($connection, [
            CURLOPT_URL => \Yii::$app->params['pds_url'] . '/person/' . $person->portal_uid,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Access: Bearer ' . \Yii::$app->params['college_pds_access_token'],
                'Authorization: Bearer ' . $token,
                'Access-Role: superadmin'
            ],
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20
        ]);
        $data = curl_exec($connection);
        $info = curl_getinfo($connection);
        curl_close($connection);

        if ($data === false) {
            throw new \yii\web\ServerErrorHttpException('Server not responding');
        }

        if ($info['http_code'] === 404) {
            throw new \yii\web\UnprocessableEntityHttpException('Person not found');
        }

        return Json::decode($data);
    }

    private function getPersonObject(array $personData): PdsPersonInterface
    {
        $model = new PdsPersonInterface();
        $model->id = $personData['id'];
        $model->lastname = $personData['lastname'];
        $model->middlename = $personData['middlename'];
        $model->firstname = $personData['firstname'];
        $model->create_ts = $personData['create_ts'];
        $model->birth_date = $personData['birth_date'];
        $model->iin = $personData['iin'];

        return $model;
    }

    /**
     * @return Person
     * @throws UnauthorizedHttpException
     */
    private function getUser()
    {
        if (\Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException('User has not authorized');
        }

        return \Yii::$app->user;
    }

    /**
     * @return \common\models\person\AccessToken
     * @throws ForbiddenHttpException
     * @throws UnauthorizedHttpException
     */
    private function getAccessToken()
    {
        $user = $this->getUser();

        $accessToken = $user->activeAccessToken;
        if (!$accessToken) {
            throw new ForbiddenHttpException('User not allowed');
        }

        return $accessToken;
    }
}