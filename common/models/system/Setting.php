<?php

namespace common\models\system;

use Yii;

/**
 * This is the model class for table "{{%system.setting}}".
 *
 * @property string $name
 * @property string $value
 */
class Setting extends \yii\db\ActiveRecord
{
    const PDS_TOKEN_NAME = 'pds_access_token';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%system.setting}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    public function fields()
    {
        return [
            'name',
            'value'
        ];
    }

    public static function addPdsToken(string $token): Setting
    {
        self::guardExists(self::PDS_TOKEN_NAME);

        $model = new Setting();
        $model->name = self::PDS_TOKEN_NAME;
        $model->value = $token;

        return $model;
    }

    public static function getPdsToken(): string
    {
        $model = Setting::findOne(['name' => self::PDS_TOKEN_NAME]);

        if (!$model) {
            return Yii::$app->params['pds_access_token'];
        }

        return $model->value;
    }

    private static function guardExists($name)
    {
        $model = Setting::findOne(['name' => $name]);

        if ($model) {
            throw new \DomainException("Setting {$name} already exists");
        }
    }
}
