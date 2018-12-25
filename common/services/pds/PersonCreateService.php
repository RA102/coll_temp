<?php

namespace common\services\pds;

use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

class PersonCreateService extends PersonSearchService
{
    /**
     * @param PdsPersonInterface $person
     * @return PdsPersonInterface
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function create(PdsPersonInterface $person): PdsPersonInterface
    {
        $query = array_filter($person->getAttributes());
        $persons = $this->findAll($query);
        if (!empty($persons)) {
            throw new ForbiddenHttpException('Person already exists');
        }

        $userToken = $this->getAccessToken();
        $response = $this->createPdsPerson($query, $userToken);
        return $this->getPersonObject($response);
    }

    private function createPdsPerson(array $attributes, $token)
    {
        $connection = curl_init();
        if (!$connection) {
            throw new \Exception('Could not connect to remote server');
        }

        curl_setopt_array($connection, [
            CURLOPT_URL => \Yii::$app->params['pds_url'] . '/person',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Access: Bearer ' . \Yii::$app->params['college_pds_access_token'],
                'Authorization: Bearer ' . $token,
                'Access-Role: superadmin'
            ],
            CURLOPT_POSTFIELDS => Json::encode($attributes),
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

        return Json::decode($data);
    }
}
