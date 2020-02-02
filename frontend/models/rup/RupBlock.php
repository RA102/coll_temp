<?php

namespace frontend\models\rup;

use Yii;

/**
 * This is the model class for table "rup_block".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $time
 *
 * @property RupSubBlock $rupSubBlock
 */
class RupBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rup_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'time'], 'required'],
            [['time'], 'default', 'value' => null],
            [['time'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRupSubBlock()
    {
        return $this->hasOne(RupSubBlock::className(), ['id' => 'id']);
    }
}
