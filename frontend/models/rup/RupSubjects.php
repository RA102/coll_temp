<?php

namespace frontend\models\rup;

use Yii;
use yii\widgets\Block;

/**
 * This is the model class for table "rup_subjects".
 *
 * @property int $id
 * @property int $id_sub_block
 * @property int $id_block
 * @property int $exam
 * @property int $control_work
 * @property int $offset
 * @property int $time
 * @property int $teory_time
 * @property int $lab_time
 * @property int $production_practice_time
 * @property int $one_sem_time
 * @property int $two_sem_time
 * @property int $three_sem_time
 * @property int $four_sem_time
 * @property int $five_sem_time
 * @property int $six_sem_time
 * @property int $seven_sem_time
 * @property int $eight_sem_time
 *
 * @property RupModule $subBlock
 */
class RupSubjects extends \yii\db\ActiveRecord
{
    public $NotTime;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rup_subjects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sub_block', 'id_block', 'exam', 'control_work', 'offset', 'time', 'teory_time', 'lab_time', 'production_practice_time', 'one_sem_time', 'two_sem_time', 'three_sem_time', 'four_sem_time', 'five_sem_time', 'six_sem_time', 'seven_sem_time', 'eight_sem_time'], 'required'],
            [['notTime','block','subBlock'],'safe'],
            [['id_sub_block', 'id_block', 'exam', 'control_work', 'offset', 'time', 'teory_time', 'lab_time', 'production_practice_time', 'one_sem_time', 'two_sem_time', 'three_sem_time', 'four_sem_time', 'five_sem_time', 'six_sem_time', 'seven_sem_time', 'eight_sem_time'], 'default', 'value' => null],
            [['id_sub_block', 'id_block', 'exam', 'control_work', 'offset', 'time', 'teory_time', 'lab_time', 'production_practice_time', 'one_sem_time', 'two_sem_time', 'three_sem_time', 'four_sem_time', 'five_sem_time', 'six_sem_time', 'seven_sem_time', 'eight_sem_time'], 'integer'],
            [['id_sub_block'], 'exist', 'skipOnError' => true, 'targetClass' => RupModule::className(), 'targetAttribute' => ['id_sub_block' => 'id']],
            [['id_block'], 'exist', 'skipOnError' => true, 'targetClass' => RupBlock::className(), 'targetAttribute' => ['id_block' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_sub_block' => 'Id Sub Block',
            'id_block' => 'Id Block',
            'exam' => 'Exam',
            'control_work' => 'Control Work',
            'offset' => 'Offset',
            'time' => 'Время всего',
            'teory_time' => 'Teory Time',
            'lab_time' => 'Lab Time',
            'production_practice_time' => 'Production Practice Time',
            'one_sem_time' => 'One Sem Time',
            'two_sem_time' => 'Two Sem Time',
            'three_sem_time' => 'Three Sem Time',
            'four_sem_time' => 'Four Sem Time',
            'five_sem_time' => 'Five Sem Time',
            'six_sem_time' => 'Six Sem Time',
            'seven_sem_time' => 'Seven Sem Time',
            'eight_sem_time' => 'Eight Sem Time',
            'name'=>'Квалификация',
            'notTime'=>'Нераспред.'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubBlock()
    {
        return $this->hasOne(RupModule::className(), ['id' => 'id_sub_block']);
    }
    public function getBlock()
    {
        return $this->hasOne(RupBlock::className(), ['id' => 'id_block']);
    }

    public function getNotTime()
    {
        return $this->time-($this->production_practice_time+$this->lab_time+$this->teory_time);
    }
}
