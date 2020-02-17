<?php

namespace frontend\models\rup;

use api\modules\v1\Module;
use Yii;

/**
 * This is the model class for table "rup_block".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $time
 *
 * @property RupModule $rupSubBlock
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
            [['code', 'name', 'time','rup_id'], 'required'],
            [['time'], 'default', 'value' => null],
            [['time','rup_id'], 'integer'],
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
            'id' => 'id',
            'code' => 'Индекс',
            'name' => 'Наименование',
            'time' => 'Часов всего',
            'rup_id' => 'Айди рупа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRupSubBlock()
    {
        return $this->hasOne(RupModule::className(), ['id' => 'id']);
    }
    public function getTimemodulededucted(){
        $sum2=RupModule::find()->where(['block_id'=>$this->id])->andWhere(['rup_id'=>$this->rup_id])->all();
        $sum3=0;
        foreach ($sum2 as $s){
            $sum3=$s->timemodulededucted+$sum3;
        }
        $sum = RupModule::find()->select(['time'])->where(['block_id'=>$this->id])->andWhere(['rup_id'=>$this->rup_id])->sum('time');
        return $this->time-($sum+$sum3);
    }
}
