<?php

namespace common\services\pds;

use common\gateways\pds\PdsGateway;
use common\services\pds\exceptions\PersonAlreadyExistException;
use yii\helpers\Json;

class PersonCreateService extends PersonSearchService
{
    private $pdsGateway;

    /**
     * PersonCreateService constructor.
     * @param PdsGateway $pdsGateway
     */
    public function __construct(PdsGateway $pdsGateway)
    {
        $this->pdsGateway = $pdsGateway;
    }

    /**
     * @param PdsPersonInterface $person
     * @return PdsPersonInterface
     * @throws \Exception
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
     */
    private function createPdsPerson(array $attributes, string $token, string $role)
    {
        // NOTE: we need to generate password for user, which we will send to user via email
        // TODO: Temporary solution
        $attributes['validation'] = \Yii::$app->security->generateRandomString(8);
        $data = $this->pdsGateway->createPerson($attributes, $token, $role);
        return array_merge(Json::decode($data), ['validation' => $attributes['validation']]);
    }
}
