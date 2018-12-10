<?php

namespace common\models;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "person.nationality".
 *
 * @property int $id
 * @property string $name
 * @property int $sort
 */
class Nationality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PERSON . 'nationality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sort'], 'default', 'value' => null],
            [['sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'sort' => 'Sort',
        ];
    }
}
