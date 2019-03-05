<?php

namespace common\services;

use common\gateways\bilimal\BilimalNotificationsGateway;
use yii\helpers\Html;

class NotificationService
{
    private $bilimalNotificationsGateway;

    /**
     * NotificationsService constructor.
     * @param BilimalNotificationsGateway $bilimalNotificationsGateway
     */
    public function __construct(
        BilimalNotificationsGateway $bilimalNotificationsGateway
    ) {
        $this->bilimalNotificationsGateway = $bilimalNotificationsGateway;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function sendRegistrationCompletedNotification(string $email)
    {
        // TODO: add i18n
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Регистрация на bilimal',
            'Вы успешно завершили регистрацию на сервисе bilimal.',
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
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Добро пожаловать на проект Bilimal!',
            "Для Вас была создана новая учетная запись. Пароль для входа в систему: {$password}",
            [$email]
        );
    }

    /**
     * @param string $email
     * @param string $resetUrl
     * @return bool
     */
    public function sendPasswordResetNotification(string $email, string $resetUrl)
    {
        // TODO: consider removing dependency on specific framework helper
        $encodedResetUrl = Html::encode($resetUrl);
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Смена пароля',
            "Пройдите по ссылке <a href=\"{$encodedResetUrl}\">$resetUrl</a> для изменения пароля",
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
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Добро пожаловать на проект Bilimal!',
            "Для Вас была создана новая учетная запись. Пароль для входа в систему: {$password}",
            [$email]
        );
    }

}