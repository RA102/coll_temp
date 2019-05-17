<?php

namespace common\utils;

class SecurityUtils
{

    const DEFAULT_PASSWORD_LENGTH = 8;

    /**
     * @param int $length
     * @return string
     */
    public static function generatePassword(int $length = self::DEFAULT_PASSWORD_LENGTH)
    {
        return \Yii::$app->security->generateRandomString($length);
    }
}