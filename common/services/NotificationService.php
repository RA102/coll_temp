<?php

namespace common\services;

use common\components\EmailRenderer;
use common\gateways\bilimal\BilimalNotificationsGateway;

class NotificationService
{
    private $bilimalNotificationsGateway;
    private $emailRenderer;

    /**
     * NotificationsService constructor.
     * @param BilimalNotificationsGateway $bilimalNotificationsGateway
     * @param EmailRenderer $emailRenderer
     */
    public function __construct(
        BilimalNotificationsGateway $bilimalNotificationsGateway,
        EmailRenderer $emailRenderer
    ) {
        $this->bilimalNotificationsGateway = $bilimalNotificationsGateway;
        $this->emailRenderer = $emailRenderer;
    }

    /**
     * @param string $email
     * @throws \Exception
     */
    public function sendRegistrationCompletedNotification(string $email)
    {
        $htmlMessage = $this->emailRenderer->render('signup');

        $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Регистрация на bilimal'),
            $htmlMessage,
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $password
     * @throws \Exception
     */
    public function sendPersonCreatedNotification($email, $password)
    {
        $htmlMessage = $this->emailRenderer->render('welcome', [
            'password' => $password
        ]);

        $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Добро пожаловать на проект Bilimal!'),
            $htmlMessage,
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $token
     * @throws \Exception
     */
    public function sendPasswordResetNotification(string $email, string $token)
    {
        $htmlMessage = $this->emailRenderer->render('passwordReset', [
            'token' => $token
        ]);

        $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Смена пароля'),
            $htmlMessage,
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $password
     * @throws \Exception
     */
    public function sendCredentialCreatedNotification(string $email, string $password)
    {
        $htmlMessage = $this->emailRenderer->render('welcome', [
            'password' => $password
        ]);

        $this->bilimalNotificationsGateway->sendEmailNotification(
            \Yii::t('app', 'Добро пожаловать на проект Bilimal!'),
            $htmlMessage,
            [$email]
        );
    }

}