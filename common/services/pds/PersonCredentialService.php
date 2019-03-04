<?php

namespace common\services\pds;

use common\exceptions\TranslatableException;
use common\gateways\bilimal\BilimalNotificationsGateway;
use common\gateways\pds\PdsGateway;
use common\models\person\Person;
use common\models\person\PersonCredential;
use common\services\NotificationService;

class PersonCredentialService
{
    const PERSON_CREDENTIAL_CREATED_STATUS = 1;
    const PERSON_CREDENTIAL_DELETED_STATUS = 3;

    const TYPE_EMAIL = 'email';

    private $notificationService;
    private $pdsGateway;

    /**
     * PersonCredentialService constructor.
     * @param NotificationService $notificationService
     * @param PdsGateway $pdsGateway
     */
    public function __construct(NotificationService $notificationService, PdsGateway $pdsGateway)
    {
        $this->notificationService = $notificationService;
        $this->pdsGateway = $pdsGateway;
    }

    /**
     * @param int $person_id
     * @param string $identity
     * @param string $token
     * @return PersonCredential
     * @throws \Exception
     */
    public function create(int $person_id, string $identity, string $token): PersonCredential
    {
        $person = Person::findIdentity($person_id);
        if (!$person) {
            throw new \RuntimeException("Person Does Not Exist");
        }
        $personCredentialExists = PersonCredential::find()->where(['indentity' => $identity])->exists();
        if ($personCredentialExists) {
            throw new \RuntimeException("Person Credential Already Exists");
        }

        $personCredentialResponse = $this->pdsGateway->createPersonCredential(
            $person->portal_uid,
            $identity,
            $token,
            self::TYPE_EMAIL
        );
        $password = $personCredentialResponse->validation_clear;
        // TODO: add queue for notifications
        $this->notificationService->sendCredentialCreatedNotification(
            $identity,
            $password
        );

        $model = PersonCredential::add($person, $identity);
        if (!$model->save()) {
            throw new \RuntimeException('Saving error');
        }

        return $model;
    }
}
