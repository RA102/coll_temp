<?php

namespace common\forms\auth;

use common\services\pds\LoginService;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

    private $loginService;

    public function __construct(LoginService $loginService, array $config = [])
    {
        $this->loginService = $loginService;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->loginService->login($this->username, $this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
}