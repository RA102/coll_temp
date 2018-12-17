<?php

namespace common\models\person;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "person.person_info".
 *
 * @property int $id
 * @property int $person_id
 * @property string $name
 * @property string $value
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Person $person
 */
class PersonInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PERSON . 'person_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'name'], 'required'],
            [['person_id', 'status'], 'default', 'value' => null],
            [['person_id', 'status'], 'integer'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['name'], 'string', 'max' => 128],
            [['value'], 'string', 'max' => 255],
            [['person_id', 'name'], 'unique', 'targetAttribute' => ['person_id', 'name']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['person_id' => 'id']],
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
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
            'import_ts' => Yii::t('app', 'Import Ts'),
        ];
    }

    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }

    public static function add(Person $person, $name, $value, $status = 1): PersonInfo
    {
        $model = new static();
        $model->person_id = $person->id;
        $model->name = $name;
        $model->value = $value;
        $model->status = $status;

        return $model;
    }
}
