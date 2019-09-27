<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDiscipline;
use common\models\organization\Group;
use common\models\person\Employee;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "optional_disciplines".
 *
 * @property int $id
 * @property int $discipline_id
 * @property int $teacher_id
 * @property array $lections_hours
 * @property array $seminars_hours
 * @property array $course_works_hours
 * @property array $tests_hours
 * @property array $offsets_hours
 * @property array $consultations_hours
 * @property array $exams_hours
 * @property array $students
 *
 */
class OptionalDisciplines extends \yii\db\ActiveRecord
{
    public $group;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'optional_disciplines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_id', 'teacher_id'], 'required'],
            [['lections_hours', 'seminars_hours', 'course_works_hours', 'tests_hours', 'offsets_hours', 'consultations_hours', 'exams_hours', 'students'], 'default', 'value' => null],
            [['lections_hours', 'seminars_hours', 'course_works_hours', 'tests_hours', 'offsets_hours', 'consultations_hours', 'exams_hours', 'students'], 'safe'],
            [['discipline_id', 'teacher_id'], 'integer'],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'discipline_id' => Yii::t('app', 'Discipline ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'lections_hours' => 'Кол-во часов на лекции',
            'seminars_hours' => 'Кол-во часов на семинары',
            'course_works_hours' => 'Кол-во часов на курсовые работы',
            'tests_hours' => 'Кол-во часов на контрольные работы',
            'offsets_hours' => 'Кол-во часов на зачёт',
            'consultations_hours' => 'Кол-во часов на консультации',
            'exams_hours' => 'Кол-во часов на экзамены',
            'students' => 'Учащиеся',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDiscipline()
    {
        return $this->hasOne(InstitutionDiscipline::class, ['id' => 'discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Employee::class, ['id' => 'teacher_id']);
    }

    public function forYear($property)
    {
        return $this->$property[1] + $this->$property[2];
    }

    public function totalHours($semester)
    {
        if ($semester == 3) {
            $total = $this->forYear('lections_hours') + $this->forYear('seminars_hours') + $this->forYear('course_works_hours') + $this->forYear('tests_hours') + $this->forYear('offsets_hours') + $this->forYear('consultations_hours') + $this->forYear('exams_hours');
        }
        else $total = $this->lections_hours[$semester] + $this->seminars_hours[$semester] + $this->course_works_hours[$semester] + $this->tests_hours[$semester] + $this->offsets_hours[$semester] + $this->consultations_hours[$semester] + $this->exams_hours[$semester];

        return $total;
    }

}
