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
 * @property string $exam
 * @property string $control_work
 * @property string $offset
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
 * @property string $name
 * @property int $rup_id
 * @property string $code
 * @property string $id_discipline
 * @property int $one_sem_teory_time
 * @property int $two_sem_teory_time
 * @property int $three_sem_teory_time
 * @property int $four_sem_teory_time
 * @property int $five_sem_teory_time
 * @property int $six_sem_teory_time
 * @property int $seven_sem_teory_time
 * @property int $eight_sem_teory_time
 * @property int $one_sem_lab_time
 * @property int $two_sem_lab_time
 * @property int $three_sem_lab_time
 * @property int $four_sem_lab_time
 * @property int $five_sem_lab_time
 * @property int $six_sem_lab_time
 * @property int $seven_sem_lab_time
 * @property int $eight_sem_lab_time
 * @property int $one_sem_production_practice_time
 * @property int $two_sem_production_practice_time
 * @property int $three_sem_production_practice_time
 * @property int $four_sem_production_practice_time
 * @property int $five_sem_production_practice_time
 * @property int $six_sem_production_practice_time
 * @property int $seven_sem_production_practice_time
 * @property int $eight_sem_production_practice_time
 * @property int $one_sem_exam
 * @property int $two_sem_exam
 * @property int $three_sem_exam
 * @property int $four_sem_exam
 * @property int $five_sem_exam
 * @property int $six_sem_exam
 * @property int $seven_sem_exam
 * @property int $eight_sem_exam
 * @property int $one_sem_offset
 * @property int $two_sem_offset
 * @property int $three_sem_offset
 * @property int $four_sem_offset
 * @property int $five_sem_offset
 * @property int $six_sem_offset
 * @property int $seven_sem_offset
 * @property int $eight_sem_offset
 * @property int $one_sem_control_work
 * @property int $two_sem_control_work
 * @property int $three_sem_control_work
 * @property int $four_sem_control_work
 * @property int $five_sem_control_work
 * @property int $six_sem_control_work
 * @property int $seven_sem_control_work
 * @property int $eight_sem_control_work
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
            [['id_sub_block', 'id_block', 'exam', 'control_work', 'offset', 'time', 'teory_time', 'lab_time', 'production_practice_time', 'one_sem_time', 'two_sem_time', 'three_sem_time', 'four_sem_time', 'five_sem_time', 'six_sem_time', 'seven_sem_time', 'eight_sem_time', 'rup_id', 'id_discipline', 'one_sem_teory_time', 'two_sem_teory_time', 'three_sem_teory_time', 'four_sem_teory_time', 'five_sem_teory_time', 'six_sem_teory_time', 'seven_sem_teory_time', 'eight_sem_teory_time', 'one_sem_lab_time', 'two_sem_lab_time', 'three_sem_lab_time', 'four_sem_lab_time', 'five_sem_lab_time', 'six_sem_lab_time', 'seven_sem_lab_time', 'eight_sem_lab_time', 'one_sem_production_practice_time', 'two_sem_production_practice_time', 'three_sem_production_practice_time', 'four_sem_production_practice_time', 'five_sem_production_practice_time', 'six_sem_production_practice_time', 'seven_sem_production_practice_time', 'eight_sem_production_practice_time', 'one_sem_exam', 'two_sem_exam', 'three_sem_exam', 'four_sem_exam', 'five_sem_exam', 'six_sem_exam', 'seven_sem_exam', 'eight_sem_exam', 'one_sem_offset', 'two_sem_offset', 'three_sem_offset', 'four_sem_offset', 'five_sem_offset', 'six_sem_offset', 'seven_sem_offset', 'eight_sem_offset', 'one_sem_control_work', 'two_sem_control_work', 'three_sem_control_work', 'four_sem_control_work', 'five_sem_control_work', 'six_sem_control_work', 'seven_sem_control_work', 'eight_sem_control_work'], 'default', 'value' => null],
            [['id_sub_block', 'id_block', 'time', 'teory_time', 'lab_time', 'production_practice_time', 'one_sem_time', 'two_sem_time', 'three_sem_time', 'four_sem_time', 'five_sem_time', 'six_sem_time', 'seven_sem_time', 'eight_sem_time', 'rup_id', 'id_discipline', 'one_sem_teory_time', 'two_sem_teory_time', 'three_sem_teory_time', 'four_sem_teory_time', 'five_sem_teory_time', 'six_sem_teory_time', 'seven_sem_teory_time', 'eight_sem_teory_time', 'one_sem_lab_time', 'two_sem_lab_time', 'three_sem_lab_time', 'four_sem_lab_time', 'five_sem_lab_time', 'six_sem_lab_time', 'seven_sem_lab_time', 'eight_sem_lab_time', 'one_sem_production_practice_time', 'two_sem_production_practice_time', 'three_sem_production_practice_time', 'four_sem_production_practice_time', 'five_sem_production_practice_time', 'six_sem_production_practice_time', 'seven_sem_production_practice_time', 'eight_sem_production_practice_time', 'one_sem_exam', 'two_sem_exam', 'three_sem_exam', 'four_sem_exam', 'five_sem_exam', 'six_sem_exam', 'seven_sem_exam', 'eight_sem_exam', 'one_sem_offset', 'two_sem_offset', 'three_sem_offset', 'four_sem_offset', 'five_sem_offset', 'six_sem_offset', 'seven_sem_offset', 'eight_sem_offset', 'one_sem_control_work', 'two_sem_control_work', 'three_sem_control_work', 'four_sem_control_work', 'five_sem_control_work', 'six_sem_control_work', 'seven_sem_control_work', 'eight_sem_control_work'], 'integer'],
            [['name'], 'string', 'max' => 400],
            [['notTime','exam', 'control_work', 'offset'],'safe'],
            [['code'], 'string', 'max' => 20],
//            [['exam', 'control_work', 'offset', ], 'string', 'max' => 6],
            [['id_sub_block'], 'exist', 'skipOnError' => true, 'targetClass' => RupModule::className(), 'targetAttribute' => ['id_sub_block' => 'id']],
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
            'notTime'=>'Нераспред.',
            'one_sem_teory_time' => 'One Sem Teory Time',
            'two_sem_teory_time' => 'Two Sem Teory Time',
            'three_sem_teory_time' => 'Three Sem Teory Time',
            'four_sem_teory_time' => 'Four Sem Teory Time',
            'five_sem_teory_time' => 'Five Sem Teory Time',
            'six_sem_teory_time' => 'Six Sem Teory Time',
            'seven_sem_teory_time' => 'Seven Sem Teory Time',
            'eight_sem_teory_time' => 'Eight Sem Teory Time',
            'one_sem_lab_time' => 'One Sem Lab Time',
            'two_sem_lab_time' => 'Two Sem Lab Time',
            'three_sem_lab_time' => 'Three Sem Lab Time',
            'four_sem_lab_time' => 'Four Sem Lab Time',
            'five_sem_lab_time' => 'Five Sem Lab Time',
            'six_sem_lab_time' => 'Six Sem Lab Time',
            'seven_sem_lab_time' => 'Seven Sem Lab Time',
            'eight_sem_lab_time' => 'Eight Sem Lab Time',
            'one_sem_production_practice_time' => 'One Sem Production Practice Time',
            'two_sem_production_practice_time' => 'Two Sem Production Practice Time',
            'three_sem_production_practice_time' => 'Three Sem Production Practice Time',
            'four_sem_production_practice_time' => 'Four Sem Production Practice Time',
            'five_sem_production_practice_time' => 'Five Sem Production Practice Time',
            'six_sem_production_practice_time' => 'Six Sem Production Practice Time',
            'seven_sem_production_practice_time' => 'Seven Sem Production Practice Time',
            'eight_sem_production_practice_time' => 'Eight Sem Production Practice Time',
            'one_sem_exam' => 'One Sem Exam',
            'two_sem_exam' => 'Two Sem Exam',
            'three_sem_exam' => 'Three Sem Exam',
            'four_sem_exam' => 'Four Sem Exam',
            'five_sem_exam' => 'Five Sem Exam',
            'six_sem_exam' => 'Six Sem Exam',
            'seven_sem_exam' => 'Seven Sem Exam',
            'eight_sem_exam' => 'Eight Sem Exam',
            'one_sem_offset' => 'One Sem Offset',
            'two_sem_offset' => 'Two Sem Offset',
            'three_sem_offset' => 'Three Sem Offset',
            'four_sem_offset' => 'Four Sem Offset',
            'five_sem_offset' => 'Five Sem Offset',
            'six_sem_offset' => 'Six Sem Offset',
            'seven_sem_offset' => 'Seven Sem Offset',
            'eight_sem_offset' => 'Eight Sem Offset',
            'one_sem_control_work' => 'One Sem Control Work',
            'two_sem_control_work' => 'Two Sem Control Work',
            'three_sem_control_work' => 'Three Sem Control Work',
            'four_sem_control_work' => 'Four Sem Control Work',
            'five_sem_control_work' => 'Five Sem Control Work',
            'six_sem_control_work' => 'Six Sem Control Work',
            'seven_sem_control_work' => 'Seven Sem Control Work',
            'eight_sem_control_work' => 'Eight Sem Control Work',
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
