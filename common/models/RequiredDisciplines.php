<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDiscipline;
use common\models\organization\Group;
use common\models\person\Employee;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "required_disciplines".
 *
 * @property int $id
 * @property int $discipline_id
 * @property int $group_id
 * @property int $teacher_id
 * @property int $semester
 * @property string $lections_hours
 * @property string $seminars_hours
 * @property string $course_works_hours
 * @property string $tests_hours
 * @property string $consultations_hours
 * @property string $exams_hours
 *
 */
class RequiredDisciplines extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'required_disciplines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_id', 'group_id', 'teacher_id', 'semester'], 'required'],
            [['lections_hours', 'seminars_hours', 'course_works_hours', 'tests_hours', 'consultations_hours', 'exams_hours'], 'default', 'value' => null],
            [['discipline_id', 'group_id', 'teacher_id', 'semester'], 'integer'],
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
            'group_id' => Yii::t('app', 'Group'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'semester' => 'Семестр',
            'lections_hours' => 'Кол-во часов на лекции',
            'seminars_hours' => 'Кол-во часов на семинары',
            'course_works_hours' => 'Кол-во часов на курсовые работы',
            'tests_hours' => 'Кол-во часов на контрольные работы',
            'consultations_hours' => 'Кол-во часов на консультации',
            'exams_hours' => 'Кол-во часов на экзамены',
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
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Employee::class, ['id' => 'teacher_id']);
    }

}
