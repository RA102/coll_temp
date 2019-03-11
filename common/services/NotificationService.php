<?php

namespace common\services;

use common\components\EmailComposer;
use common\gateways\bilimal\BilimalNotificationsGateway;

class NotificationService
{
    private $bilimalNotificationsGateway;
    private $emailComposer;

    /**
     * NotificationsService constructor.
     * @param BilimalNotificationsGateway $bilimalNotificationsGateway
     * @param EmailComposer $emailComposer
     */
    public function __construct(
        BilimalNotificationsGateway $bilimalNotificationsGateway,
        EmailComposer $emailComposer
    ) {
        $this->bilimalNotificationsGateway = $bilimalNotificationsGateway;
        $this->emailComposer = $emailComposer;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function sendRegistrationCompletedNotification(string $email)
    {
        $htmlMessage = $this->emailComposer->compose('signup');

        return $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Регистрация на bilimal'),
            $htmlMessage,
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function sendPersonCreatedNotification(string $email, string $password)
    {
        $htmlMessage = $this->emailComposer->compose('welcome', [
            'password' => $password
        ]);

        return $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Добро пожаловать на проект Bilimal!'),
            $htmlMessage,
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $token
     * @return bool
     */
    public function sendPasswordResetNotification(string $email, string $token)
    {
        $htmlMessage = $this->emailComposer->compose('passwordReset', [
            'token' => $token
        ]);

        return $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Смена пароля'),
            $htmlMessage,
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function sendCredentialCreatedNotification(string $email, string $password)
    {
        $htmlMessage = $this->emailComposer->compose('welcome', [
            'password' => $password
        ]);

        return $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Добро пожаловать на проект Bilimal!'),
            $htmlMessage,
            [$email]
        );
    }

}