<?php

namespace common\services\pds;

use common\gateways\pds\PdsGateway;
use common\helpers\PersonHelper;
use common\models\person\AccessToken;
use common\models\person\Person;
use yii\helpers\Json;

class LoginService
{
    private $pdsGateway;

    /**
     * LoginService constructor.
     * @param PdsGateway $pdsGateway
     */
    public function __construct(PdsGateway $pdsGateway)
    {
        $this->pdsGateway = $pdsGateway;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function login(string $username, string $password): bool
    {
        try {
            $authData = $this->getPdsAuthData($username, $password);
            $person = $this->getPerson($authData['person']);
            $this->saveToken($person, $authData);
            \Yii::$app->user->login($person);
            return true;
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die();
            return false;
        }
    }

    /**
     * @param string $token
     * @return Person|null
     */
    public function loginByToken(string $token)
    {
        try {
            $loginResponse = $this->pdsGateway->loginByToken($token);
            $person = Person::findIdentityByUID($loginResponse->person->id);

            return $person;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param string $username
     * @param string $password
     * @return mixed
     * @throws \Exception
     */
    private function getPdsAuthData(string $username, string $password)
    {
        $data = $this->pdsGateway->login($username, $password);

        return Json::decode($data);
    }

    /**
     * @param Person $person
     * @param array $data
     * @throws \yii\web\UnauthorizedHttpException
     */
    private function saveToken(Person $person, array $data)
    {
        $accessToken = AccessToken::find()
            ->where([
                'person_id' => $person->id,
                'token'     => $data['token']
            ])
            ->andWhere('expire_ts > NOW()')
            ->one();

        if (!$accessToken) {
            $token = PersonHelper::decodeJWT($data['token']);
            $expire = new \DateTime();
            $expire->setTimestamp($token['exp']);

            $accessToken = AccessToken::add(
                $person,
                $data['token'],
                $expire,
                $data['hash'],
                $data['is_temporary']
            );

            if (!$accessToken->save()) {
                throw new \DomainException($accessToken->getErrorSummary(true)[0]);
            }
        }
    }

    /**
     * @param array $personData
     * @return Person
     */
    private function getPerson(array $personData): Person
    {
        $person = Person::findIdentityByUID($personData['id']);

        if (!$person) {
            $person = Person::add(
                $personData['id'],
                $personData['firstname'],
                $personData['lastname'],
                $personData['middlename'],
                $personData['iin']
            );
        } else {
            $person->firstname = $personData['firstname'];
            $person->lastname = $personData['lastname'];
            $person->middlename = $personData['middlename'];
            $person->iin = $personData['iin'];
        }

        if (!$person->save()) {
            throw new \DomainException($person->getErrorSummary(true)[0]);
        }

        return $person;
    }
}