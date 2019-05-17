<?php

namespace common\models\person;

use Yii;

/**
 * This is the model class for table "{{%person.access_token}}".
 *
 * @property int $id
 * @property int $person_id
 * @property string $token
 * @property bool $is_temporary
 * @property string $hash
 * @property string $create_ts
 * @property string $expire_ts
 * @property string $delete_ts
 *
 * @property Person $person
 */
class AccessToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%person.access_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'token'], 'required'],
            [['person_id'], 'default', 'value' => null],
            [['person_id'], 'integer'],
            [['is_temporary'], 'boolean'],
            [['create_ts', 'expire_ts', 'delete_ts', 'token'], 'safe'],
            [['hash'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'person_id' => Yii::t('app', 'Person ID'),
            'token' => Yii::t('app', 'Token'),
            'is_temporary' => Yii::t('app', 'Is Temporary'),
            'hash' => Yii::t('app', 'Hash'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'expire_ts' => Yii::t('app', 'Expire Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    public static function add(Person $person, $token, \DateTime $expire, $hash = '', $isTemporary = true): AccessToken
    {
        $model = new static();
        $model->person_id = $person->id;
        $model->token = $token;
        $model->hash = $hash;
        $model->is_temporary = $isTemporary;
        $model->expire_ts = $expire->format('Y-m-d H:i:s');

        return $model;
    }
}
