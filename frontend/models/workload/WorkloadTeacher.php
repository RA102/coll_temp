<?php

namespace frontend\models\workload;

use Yii;

/**
 * This is the model class for table "workload_teacher".
 *
 * @property int $id
 * @property int $rup_id
 * @property int $id_discipline
 * @property int $year
 * @property int $course
 * @property int $workload_discipline_id
 * @property string $delete_ts
 * @property string $delete_user
 * @property string $create_ts
 * @property string $create_user
 * @property int $pol1_time
 * @property int $pol2_time
 * @property int $pol1_teory_time
 * @property int $pol2_teory_time
 * @property int $pol1_lab_time
 * @property int $pol2_lab_time
 * @property int $pol1_production_practice_time
 * @property int $pol2_production_practice_time
 * @property int $pol1_exam
 * @property int $pol2_exam
 * @property int $pol1_offset
 * @property int $pol2_offset
 * @property int $pol1_control_work
 * @property int $pol2_control_work
 */
class WorkloadTeacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'workload_teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'rup_id', 'id_discipline', 'year', 'course', 'workload_discipline_id', 'pol1_time', 'pol2_time', 'pol1_teory_time', 'pol2_teory_time', 'pol1_lab_time', 'pol2_lab_time', 'pol1_production_practice_time', 'pol2_production_practice_time', 'pol1_exam', 'pol2_exam', 'pol1_offset', 'pol2_offset', 'pol1_control_work', 'pol2_control_work'], 'default', 'value' => null],
            [['id', 'rup_id', 'id_discipline', 'year', 'course', 'workload_discipline_id', 'pol1_time', 'pol2_time', 'pol1_teory_time', 'pol2_teory_time', 'pol1_lab_time', 'pol2_lab_time', 'pol1_production_practice_time', 'pol2_production_practice_time', 'pol1_exam', 'pol2_exam', 'pol1_offset', 'pol2_offset', 'pol1_control_work', 'pol2_control_work'], 'integer'],
            [['delete_ts', 'delete_user', 'create_ts', 'create_user'], 'safe'],
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
            'rup_id' => 'Rup ID',
            'id_discipline' => 'Id Discipline',
            'year' => 'Year',
            'course' => 'Course',
            'workload_discipline_id' => 'Workload Discipline ID',
            'delete_ts' => 'Delete Ts',
            'delete_user' => 'Delete User',
            'create_ts' => 'Create Ts',
            'create_user' => 'Create User',
            'pol1_time' => 'Pol1 Time',
            'pol2_time' => 'Pol2 Time',
            'pol1_teory_time' => 'Pol1 Teory Time',
            'pol2_teory_time' => 'Pol2 Teory Time',
            'pol1_lab_time' => 'Pol1 Lab Time',
            'pol2_lab_time' => 'Pol2 Lab Time',
            'pol1_production_practice_time' => 'Pol1 Production Practice Time',
            'pol2_production_practice_time' => 'Pol2 Production Practice Time',
            'pol1_exam' => 'Pol1 Exam',
            'pol2_exam' => 'Pol2 Exam',
            'pol1_offset' => 'Pol1 Offset',
            'pol2_offset' => 'Pol2 Offset',
            'pol1_control_work' => 'Pol1 Control Work',
            'pol2_control_work' => 'Pol2 Control Work',
        ];
    }

    public function getWorkloadRowObjects()
    {
        return $this->hasOne(WorkloadDiscipline::class, ['id' => 'workload_discipline_id']);
    }

}
