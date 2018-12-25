<?php

namespace common\services\pds;

use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

class PersonUpdateService extends PersonService
{
    /**
     * @param int $person_id
     * @param PdsPersonInterface $person
     * @return PdsPersonInterface
     * @throws ForbiddenHttpException
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function create(int $person_id, PdsPersonInterface $person): PdsPersonInterface
    {
        $persons = $this->findAll(['id' => $person_id]);
        if (empty($persons)) {
            throw new ForbiddenHttpException('Person not exists');
        }

        $userToken = $this->getAccessToken();
        $query = array_filter($person->getAttributes());
        $response = $this->updatePdsPerson($person_id, $query, $userToken);
        return $this->getPersonObject($response);
    }

    private function updatePdsPerson(int $person_id, array $attributes, $token)
    {
        $connection = curl_init();
        if (!$connection) {
            throw new \Exception('Could not connect to remote server');
        }

        curl_setopt_array($connection, [
            CURLOPT_URL => \Yii::$app->params['pds_url'] . '/person/' . $person_id,
            CURLOPT_CUSTOMREQUEST => 'PUT',
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
