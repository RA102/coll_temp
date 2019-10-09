<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\Practice;
use common\models\organization\Group;
use common\models\person\Employee;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "practice".
 *
 * @property int $id
 * @property int $practice_id
 * @property int $group_id
 * @property array $teacher
 * @property array $hours
 *
 */
class PracticeData extends \yii\db\ActiveRecord
{
    public $caption_current;

    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'practice_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['practice_id', 'group_id'], 'required'],
            [['teacher', 'hours'], 'default', 'value' => null],
            [['teacher', 'hours', 'caption'], 'safe'],
            [['practice_id', 'group_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'practice_id' => Yii::t('app', 'Практика'),
            'group_id' => Yii::t('app', 'Group'),
            'teacher' => Yii::t('app', 'Teacher'),
            'hours' => 'Часов',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPractice()
    {
        return $this->hasOne(Practice::class, ['id' => 'practice_id']);
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
    public function getTeacher($teacher_id)
    {
        return Employee::findOne(['id' => $teacher_id]);
    }

    public function forYear()
    {
        return intval($this->hours[1]) + intval($this->hours[2]);
    }

}
