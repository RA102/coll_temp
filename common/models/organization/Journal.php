<?php

namespace common\models\organization;

use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\link\StudentGroupLink;
use common\models\person\Student;
use common\models\TeacherCourse;
use Yii;

/**
 * This is the model class for table "organization.journal".
 * 
 *
 * @property int $id
 * @property int $type
 * @property int $institution_id
 * @property int $group_id
 * @property int $teacher_course_id
 * @property string $date_ts
 * @property array $data
 *
 */
class Journal extends \yii\db\ActiveRecord
{
    const TYPE_THEORY = 1; // теоретическое обучение
    const TYPE_COURSE_PROJECT = 2; // курсовые проекты, лабораторно-практические и графические работы
    const TYPE_TEST = 3; // контрольные работы

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'institution_id', 'group_id', 'teacher_course_id',], 'integer'],
            [['data'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'group_id' => Yii::t('app', 'Group'),
            'teacher_course_id' => Yii::t('app', 'Course ID'),
            'type' => Yii::t('app', 'Type'),
            'data' => 'Ученики',
            'date_ts' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourse()
    {
        return $this->hasOne(TeacherCourse::class, ['id' => 'teacher_course_id']);
    }
}
