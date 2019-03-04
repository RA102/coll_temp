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
        $response = $this->createPdsPerson($query, $userToken->token);
        return $this->getPersonObject($response);
    }

    /**
     * @param array $attributes
     * @param string $token
     * @return mixed
     */
    private function createPdsPerson(array $attributes, string $token)
    {
        // NOTE: we need to generate password for user, which we will send to user via email
        // TODO: Temporary solution
        $attributes['validation'] = \Yii::$app->security->generateRandomString(8);
        $data = $this->pdsGateway->createPerson($attributes, $token);
        return array_merge(Json::decode($data), ['validation' => $attributes['validation']]);
    }
}
