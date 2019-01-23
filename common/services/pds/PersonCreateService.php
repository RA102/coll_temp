<?php

namespace common\services\pds;

use common\models\system\Setting;
use common\services\pds\exceptions\PersonAlreadyExistException;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;

class PersonCreateService extends PersonSearchService
{
    /**
     * @param PdsPersonInterface $person
     * @return PdsPersonInterface
     * @throws ForbiddenHttpException
     * @throws \Throwable
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function create(PdsPersonInterface $person): PdsPersonInterface
    {
        $query = array_filter($person->getAttributes());
        $person = $this->findOne($query);

        if ($person !== null) {
            throw new PersonAlreadyExistException('Person already exists');
        }

        $userToken = $this->getAccessToken();
        $respons = $this->createPdsPerson($query, $userToken->token);
        return $this->getPersonObject($respons);
    }

    private function createPdsPerson(array $attributes, string $token)
    {
        $connection = curl_init();
        if (!$connection) {
            throw new \Exception('Could not connect to remote server');
        }

        $options = [
            CURLOPT_URL => \Yii::$app->params['pds_url'] . 'person',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Access: Bearer ' . Setting::getPdsToken(),
                'Authorization: Bearer ' . $token,
                'Access-Role: superadmin'
            ],
            CURLOPT_POSTFIELDS => json_encode($attributes),
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20
        ];
        curl_setopt_array($connection, $options);

        $data = curl_exec($connection);
        $info = curl_getinfo($connection);
        curl_close($connection);

        if ($data === false) {
            throw new \yii\web\ServerErrorHttpException('Server not responding');
        }

        if ($info['http_code'] === 405) {
            throw new MethodNotAllowedHttpException('Method not allowed');
        }

        if ($info['http_code'] !== 200) {
            throw new \yii\web\UnprocessableEntityHttpException('Error occurred');
        }

        return Json::decode($data);
    }
}
