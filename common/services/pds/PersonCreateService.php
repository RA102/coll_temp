<?php

namespace common\services\pds;

use common\services\pds\exceptions\PersonAlreadyExistException;
use common\utils\SecurityUtils;
use yii\helpers\Json;

class PersonCreateService extends PersonSearchService
{
    /**
     * @param PdsPersonInterface $person
     * @return PdsPersonInterface
     * @throws PersonAlreadyExistException
     * @throws \Throwable
     * @throws \yii\web\ForbiddenHttpException
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
        $userRole = $this->getRole();
        $response = $this->createPdsPerson($query, $userToken->token, $userRole);
        return $this->getPersonObject($response);
    }

    /**
     * @param array $attributes
     * @param string $token
     * @param string $role
     * @return mixed
     * @throws \yii\base\Exception
     */
    private function createPdsPerson(array $attributes, string $token, string $role)
    {
        // NOTE: we need to generate password for user, which we will send to user via email
        $attributes['validation'] = SecurityUtils::generatePassword();
        $data = $this->pdsGateway->createPerson($attributes, $token, $role);
        return array_merge(Json::decode($data), ['validation' => $attributes['validation']]);
    }
}
