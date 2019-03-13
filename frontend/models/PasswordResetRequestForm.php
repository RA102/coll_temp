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
    public $email;

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
                'targetClass'     => '\common\models\person\PersonCredential',
                'targetAttribute' => 'indentity',
                'message'         => 'There is no user with this email address.'
            ],
        ];
    }
}
