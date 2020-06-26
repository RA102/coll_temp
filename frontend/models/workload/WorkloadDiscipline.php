<?php

namespace frontend\models\workload;

use common\models\Discipline;
use frontend\models\rup\RupSubjects;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "workload_discipline".
 *
 * @property int $id
 * @property int $course
 * @property int $year
 * @property int $rup_time
 * @property int $pol1_time
 * @property int $rup_pol1_time
 * @property int $pol2_time
 * @property int $rup_pol2_time
 * @property int $pol1_teory_time
 * @property int $rup_pol1_teory_time
 * @property int $pol2_teory_time
 * @property int $rup_pol2_teory_time
 * @property int $pol1_lab_time
 * @property int $rup_pol1_lab_time
 * @property int $pol2_lab_time
 * @property int $rup_pol2_lab_time
 * @property int $pol1_production_practice_time
 * @property int $rup_pol1_production_practice_time
 * @property int $pol2_production_practice_time
 * @property int $rup_pol2_production_practice_time
 * @property int $pol1_exam
 * @property int $rup_pol1_exam
 * @property int $pol2_exam
 * @property int $rup_pol2_exam
 * @property int $pol1_offset
 * @property int $rup_pol1_offset
 * @property int $pol2_offset
 * @property int $rup_pol2_offset
 * @property int $pol1_control_work
 * @property int $rup_pol1_control_work
 * @property int $pol2_control_work
 * @property int $rup_pol2_control_work
 */
class WorkloadDiscipline extends \frontend\models\rup\RupSubjects
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workload_discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'course', 'year', 'rup_time', 'pol1_time', 'rup_pol1_time', 'pol2_time', 'rup_pol2_time', 'pol1_teory_time', 'rup_pol1_teory_time', 'pol2_teory_time', 'rup_pol2_teory_time', 'pol1_lab_time', 'rup_pol1_lab_time', 'pol2_lab_time', 'rup_pol2_lab_time', 'pol1_production_practice_time', 'rup_pol1_production_practice_time', 'pol2_production_practice_time', 'rup_pol2_production_practice_time', 'pol1_exam', 'rup_pol1_exam', 'pol2_exam', 'rup_pol2_exam', 'pol1_offset', 'rup_pol1_offset', 'pol2_offset', 'rup_pol2_offset', 'pol1_control_work', 'rup_pol1_control_work', 'pol2_control_work', 'rup_pol2_control_work'], 'default', 'value' => null],
            [['id', 'course', 'year', 'rup_time', 'pol1_time', 'rup_pol1_time', 'pol2_time', 'rup_pol2_time', 'pol1_teory_time', 'rup_pol1_teory_time', 'pol2_teory_time', 'rup_pol2_teory_time', 'pol1_lab_time', 'rup_pol1_lab_time', 'pol2_lab_time', 'rup_pol2_lab_time', 'pol1_production_practice_time', 'rup_pol1_production_practice_time', 'pol2_production_practice_time', 'rup_pol2_production_practice_time', 'pol1_exam', 'rup_pol1_exam', 'pol2_exam', 'rup_pol2_exam', 'pol1_offset', 'rup_pol1_offset', 'pol2_offset', 'rup_pol2_offset', 'pol1_control_work', 'rup_pol1_control_work', 'pol2_control_work', 'rup_pol2_control_work'], 'integer'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course' => 'Course',
            'year' => 'Year',
            'rup_time' => 'Rup Time',
            'pol1_time' => 'Pol1 Time',
            'rup_pol1_time' => 'Rup Pol1 Time',
            'pol2_time' => 'Pol2 Time',
            'rup_pol2_time' => 'Rup Pol2 Time',
            'pol1_teory_time' => 'Pol1 Teory Time',
            'rup_pol1_teory_time' => 'Rup Pol1 Teory Time',
            'pol2_teory_time' => 'Pol2 Teory Time',
            'rup_pol2_teory_time' => 'Rup Pol2 Teory Time',
            'pol1_lab_time' => 'Pol1 Lab Time',
            'rup_pol1_lab_time' => 'Rup Pol1 Lab Time',
            'pol2_lab_time' => 'Pol2 Lab Time',
            'rup_pol2_lab_time' => 'Rup Pol2 Lab Time',
            'pol1_production_practice_time' => 'Pol1 Production Practice Time',
            'rup_pol1_production_practice_time' => 'Rup Pol1 Production Practice Time',
            'pol2_production_practice_time' => 'Pol2 Production Practice Time',
            'rup_pol2_production_practice_time' => 'Rup Pol2 Production Practice Time',
            'pol1_exam' => 'Pol1 Exam',
            'rup_pol1_exam' => 'Rup Pol1 Exam',
            'pol2_exam' => 'Pol2 Exam',
            'rup_pol2_exam' => 'Rup Pol2 Exam',
            'pol1_offset' => 'Pol1 Offset',
            'rup_pol1_offset' => 'Rup Pol1 Offset',
            'pol2_offset' => 'Pol2 Offset',
            'rup_pol2_offset' => 'Rup Pol2 Offset',
            'pol1_control_work' => 'Pol1 Control Work',
            'rup_pol1_control_work' => 'Rup Pol1 Control Work',
            'pol2_control_work' => 'Pol2 Control Work',
            'rup_pol2_control_work' => 'Rup Pol2 Control Work',
        ];
    }

    public function getWorkloadRow()
    {
            $rows = RupSubjects::find()
            ->where('rup_id=2')
            ->all();
            foreach ($rows as $one) {
                foreach ($one as $nano)
                    echo $nano;
            }

    }

    public function getWorkloadSubRow()
    {
        return $this->hasMany(WorkloadTeacher::class, ['workload_discipline_id' => 'id']);
    }
}
