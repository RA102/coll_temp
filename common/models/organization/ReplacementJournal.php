<?php

namespace common\models\organization;

use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use common\models\link\StudentGroupLink;
use common\models\person\Student;
use common\models\person\Employee;
use common\models\TeacherCourse;
use Yii;

/**
 * This is the model class for table "organization.journal".
 * 
 *
 * @property int $id
 * @property int $group_id
 * @property int $teacher_course_id
 * @property int $new_teacher_course_id
 * @property int $new_teacher_id
 * @property string $date_ts
 * @property string $new_date_ts
 * @property string $reason
 * @property boolean $canceled
 *
 */
class ReplacementJournal extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.replacement_journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'teacher_course_id', 'new_teacher_course_id', 'new_teacher_id'], 'integer'],
            [['reason', 'date_ts', 'new_date_ts'], 'string'],
            [['canceled'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group'),
            'teacher_course_id' => Yii::t('app', 'Discipline'),
            'date_ts' => Yii::t('app', 'Date'),
            'reason' => 'причина',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacherCourse()
    {
        return $this->hasOne(TeacherCourse::class, ['id' => 'teacher_course_id']);
    }

    public function getNewTeacher()
    {
        return $this->hasOne(Employee::class, ['id' => 'new_teacher_id']);
    }

    public function replaced($group_id, $date, $teacher_course_id) 
    {
        $model = ReplacementJournal::find()->andWhere(['group_id' => $group_id, 'date_ts' => date('Y-m-d 00:00:00', $date), 'teacher_course_id' => $teacher_course_id])->one();

        if ($model !== null) {
            return true;
        } else return false;
    }
}
