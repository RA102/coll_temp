<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDiscipline;
use common\models\organization\Group;
use common\models\person\Employee;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "public.exams".
 *
 * @property int $id
 * @property int $intitution_discipline_id
 * @property int $group_id
 * @property int $exam_type
 * @property int $week
 * @property int $teacher_course_id
 *
 */
class Exams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'exams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_course_id', 'institution_discipline_id', 'group_id', 'exam_type', 'week'], 'required'],
            [['teacher_course_id', 'institution_discipline_id', 'group_id', 'exam_type', 'week'], 'integer'],
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
            'teacher_course_id' => Yii::t('app', 'Teacher Course ID'),
            'institution_discipline_id' => Yii::t('app', 'Discipline ID'),
            'group_id' => Yii::t('app', 'Group'),
            'exam_type' => 'Способ',
            'week' => 'Неделя',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDiscipline()
    {
        return $this->hasOne(InstitutionDiscipline::class, ['id' => 'institution_discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }

    public function examType($type)
    {
    	$types = ['1' => 'Контрольная работа', '2' => 'Зачёт', '3' => 'Экзамен'];

    	return $types[$type];
    }
}
