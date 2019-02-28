<?php
namespace frontend\models;

use common\services\NotificationService;
use Yii;
use yii\base\Model;
use common\models\person\Person;
use yii\helpers\Html;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    private $notificationService;

    public $email;

    /**
     * PasswordResetRequestForm constructor.
     * @param array $config
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService, array $config = [])
    {
        parent::__construct($config);

        $this->notificationService = $notificationService;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\person\Person',
                'filter' => ['status' => Person::STATUS_ACTIVE],
                'message' => 'There is no user with this email address.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user Person */
        $user = Person::findOne([
            'status' => Person::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if (!$user) {
            return false;
        }
        
        if (!Person::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        return $this->notificationService->sendPasswordChangedNotification([$this->email], $resetLink);
    }
}
