<?php

namespace common\services\pds;

use common\models\person\Person;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

class PersonSearchService
{
    /**
     * @param array $query
     * @return null
     * @throws ForbiddenHttpException
     * @throws UnauthorizedHttpException
     * @throws \yii\web\ServerErrorHttpException
     */
    public function findAll(array $query)
    {
        try {
            $userToken = $this->getAccessToken();
            $persons = $this->getPdsPersons($query, $userToken);
            return $this->getPersonsObject($persons);
        } catch (\yii\web\UnprocessableEntityHttpException $e) {
            return null;
        }
    }

    protected function getPersonsObject(array $persons): array
    {
        return array_map(function($personData) {
            return $this->getPersonObject($personData);
        }, $persons);
    }

    protected function getPersonObject(array $personData): PdsPersonInterface
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

    protected function getUrlQuery(array $query): string
    {
        return http_build_query($query);
    }

    /**
     * @return Person
     * @throws UnauthorizedHttpException
     */
    protected function getUser()
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
    protected function getAccessToken()
    {
        $user = $this->getUser();

        $accessToken = $user->activeAccessToken;
        if (!$accessToken) {
            throw new ForbiddenHttpException('User not allowed');
        }

        return $accessToken;
    }

    /**
     * @param array $query
     * @param string $token
     * @return mixed
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnprocessableEntityHttpException
     * @throws \Exception
     */
    private function getPdsPersons(array $query, string $token)
    {
        $connection = curl_init();
        if (!$connection) {
            throw new \Exception('Could not connect to remote server');
        }

        curl_setopt_array($connection, [
            CURLOPT_URL => \Yii::$app->params['pds_url'] . '/person?' . $this->getUrlQuery($query),
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
}
