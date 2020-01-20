<?php

namespace common\helpers;

use common\models\person\Person;
use Firebase\JWT\JWT;
use Yii;
use yii\web\UnauthorizedHttpException;

class PersonHelper
{
    const JWT_SECRET_KEY = 'o^ieONLzxEJ69gB&aoce20eiwU6ebj';

    public static function getTypeList()
    {
        return [
            Person::TYPE_UNDEFINED => Yii::t('app', 'PersonType Undefined'),
            Person::TYPE_STUDENT => Yii::t('app', 'PersonType Student'),
            Person::TYPE_EMPLOYEE => Yii::t('app', 'PersonType Employee'),
        ];
    }

    public static function getSexList()
    {
        return [
            Person::SEX_NONE => Yii::t('app', 'Sex None'),
            Person::SEX_MALE => Yii::t('app', 'Sex Male'),
            Person::SEX_FEMALE => Yii::t('app', 'Sex Female'),
        ];
    }

    public static function getStatusList()
    {
        return [
            Person::STATUS_ACTIVE => Yii::t('app', 'active'),
            Person::STATUS_FIRED => Yii::t('app', 'fired'),
            Person::STATUS_DELETED => Yii::t('app', 'deleted'),
        ];
    }

    /**
     * Decode JWT token
     * @param  string $token access token to decode
     * @return array decoded token
     * @throws UnauthorizedHttpException
     */
    public static function decodeJWT($token)
    {
        $secret = static::getSecretKey();
        $errorText = "Incorrect token";
        JWT::$leeway = 60; //сек, исправляет использование раньше времени начала токена

        try {
            $decoded = JWT::decode($token, $secret, [static::getAlgo()]);
        } catch (\Exception $e) {
            if (YII_DEBUG) {
                throw new UnauthorizedHttpException($e->getMessage());
            } else {
                throw new UnauthorizedHttpException($errorText);
            }
        }
        $decodedArray = (array)$decoded;
        return $decodedArray;
    }


    /**
     * Getter for secret key that's used for generation of JWT
     * @return string secret key used to generate JWT
     */
    protected static function getSecretKey()
    {
        return self::JWT_SECRET_KEY;
    }

    /**
     * Getter for encryption algorytm used in JWT generation and decoding
     * Override this method to set up other algorytm.
     * @return string needed algorytm
     */
    private static function getAlgo()
    {
        return 'HS256';
    }
}
