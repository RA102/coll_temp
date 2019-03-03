<?php

namespace common\models\person;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "person.person_credential".
 *
 * @property int $id
 * @property int $person_id
 * @property string $indentity
 * @property string $password_reset_token
 * @property string $delete_ts
 * @property string $create_ts
 * @property string $update_ts
 */
class PersonCredential extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PERSON . 'person_credential';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'indentity'], 'required'],
            [['person_id'], 'default', 'value' => null],
            [['person_id'], 'integer'],
            [['delete_ts', 'create_ts', 'update_ts'], 'safe'],
            [['indentity', 'password_reset_token'], 'string', 'max' => 255],
            [['indentity'], 'unique'],
            [
                ['person_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Person::className(),
                'targetAttribute' => ['person_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'person_id'            => Yii::t('app', 'Person ID'),
            'indentity'            => Yii::t('app', 'Indentity'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'delete_ts'            => Yii::t('app', 'Delete Ts'),
            'create_ts'            => Yii::t('app', 'Create Ts'),
            'update_ts'            => Yii::t('app', 'Update Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    /**
     * @param Person $person
     * @param string $indentity
     * @return PersonCredential
     */
    public static function add(Person $person, string $indentity): PersonCredential
    {
        $model = new static();
        $model->person_id = $person->id;
        $model->indentity = $indentity;

        return $model;
    }
}
