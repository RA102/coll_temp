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
 * This is the model class for table "organization.group".
 * Group is an entity for college group of students
 *
 * @property int $id
 * @property int $institution_id
 * @property string $number
 * @property string $name
 *
 */
class Classroom extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.classroom';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id'], 'integer'],
            [['number', 'name'], 'string'],
            [['institution_id', 'number'], 'required'],
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
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    public function getLessons()
    {
        return $this->hasMany(Lesson::class, ['classroom_id' => 'id']);
    }

}
