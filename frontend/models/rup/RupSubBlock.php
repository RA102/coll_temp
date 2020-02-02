<?php

namespace frontend\models\rup;

use Yii;

/**
 * This is the model class for table "rup_sub_block".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property RupBlock $id0
 * @property RupSubjects[] $rupSubjects
 */
class RupSubBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rup_sub_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name'], 'string'],
            [['block'],'safe'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => RupBlock::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Индекс',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(RupBlock::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRupSubjects()
    {
        return $this->hasMany(RupSubjects::className(), ['id_sub_block' => 'id']);
    }
}
