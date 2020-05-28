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
 * @property bool $isTemplate
 *
 * @property RupModule $rupSubBlock
 * @property RupModule[] $rupModules
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
            ['name', 'unique', 'when' => function($model) {
                return $model->isTemplate == false;
            }, 'whenClient' => "function (attribute, value) {
        return $('#isTemplate').val() == false;
    }"],
            [['code', 'name', 'time','rup_id','isTemplate'], 'required'],
            [['time'], 'default', 'value' => null],
            [['time','rup_id'], 'integer'],
            [['isTemplate'], 'boolean'],
            [['code', 'qual_code'], 'string', 'max' => 20],
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
            'isTemplate' => 'Добавить в шаблоны',
            'qual_code' => 'Квалификация'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRupSubBlock()
    {
        return $this->hasMany(RupModule::className(), ['block_id' => 'id']);
    }

    public function getSubjects()
    {
        return $this->hasMany(RupSubjects::className(), ['id_block' => 'id']);
    }


    public function getTimemodulededucted(){
        $sum2=RupModule::find()->where(['block_id'=>$this->id])->andWhere(['rup_id'=>$this->rup_id])->all();
        $sum3=0;
        foreach ($sum2 as $s){
            $sum3=$s->timemodulededucted+$sum3;
        }
        $sum = RupModule::find()->select(['time'])->where(['block_id'=>$this->id])->andWhere(['rup_id'=>$this->rup_id])->sum('time');
        return ($this->time-$sum)+$sum3;
    }
}
