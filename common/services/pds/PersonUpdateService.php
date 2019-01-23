<?php

namespace common\services\pds;

use common\services\pds\exceptions\PersonNotExistException;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

class PersonUpdateService extends PersonSearchService
{
    /**
     * @param int $person_id
     * @param PdsPersonInterface $person
     * @return PdsPersonInterface
     * @throws ForbiddenHttpException
     * @throws \Throwable
     * @throws \yii\web\ServerErrorHttpException
     * @throws \yii\web\UnauthorizedHttpException
     */
    public function update(int $person_id, PdsPersonInterface $person): PdsPersonInterface
    {
        $persons = $this->findOne(['id' => $person_id]);
        if (empty($persons)) {
            throw new PersonNotExistException('Person not exists');
        }

        $userToken = $this->getAccessToken();
        $query = array_filter($person->getAttributes());
        $response = $this->updatePdsPerson($person_id, $query, $userToken->token);
        return $this->getPersonObject($response);
    }

    private function updatePdsPerson(int $person_id, array $attributes, string $token)
    {
        $connection = curl_init();
        if (!$connection) {
            throw new \Exception('Could not connect to remote server');
        }

        $url = \Yii::$app->params['pds_url'] . 'person?id=' . $person_id;
        curl_setopt_array($connection, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Access: Bearer ' . \Yii::$app->params['pds_access_token'],
                'Authorization: Bearer ' . $token,
                'Access-Role: superadmin'
            ],
            CURLOPT_POSTFIELDS => json_encode($attributes),
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
            throw new NotFoundHttpException('Person not found');
        }

        if ($info['http_code'] === 405) {
            throw new MethodNotAllowedHttpException('Method not allowed');
        }

        if ($info['http_code'] !== 200) {
            throw new UnprocessableEntityHttpException('Error occurred');
        }

        return Json::decode($data);
    }
}
