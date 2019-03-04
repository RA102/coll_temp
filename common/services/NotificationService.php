<?php

namespace common\services;

use common\gateways\bilimal\BilimalNotificationsGateway;
use yii\helpers\Html;

class NotificationService {

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
     * @param array $addresses
     * @return bool
     */
    public function sendRegistrationCompleteNotification(array $addresses) {
        // TODO: add i18n
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Регистрация на bilimal',
            'Вы успешно завершили регистрацию на сервисе bilimal.',
            $addresses);
    }


    /**
     * @param array $addresses
     * @return bool
     */
    public function sendPersonCreatedNotification(array $addresses) {
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Регистрация на bilimal',
            'Вы успешно завершили регистрацию на сервисе bilimal.',
            $addresses);
    }

    /**
     * @param array $addresses
     * @param string $resetUrl
     * @return bool
     */
    public function sendPasswordChangedNotification(array $addresses, string $resetUrl) {
        // TODO: consider removing dependency on specific framework helper
        $encodedResetUrl = Html::encode($resetUrl);
        return $this->bilimalNotificationsGateway->sendEmailNotification(
            'Смена пароля',
            "Пройдите по ссылке <a href=\"{$encodedResetUrl}\">$resetUrl</a> для изменения пароля",
            $addresses);
    }

}