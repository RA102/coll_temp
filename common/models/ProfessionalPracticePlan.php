<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\ProfessionalPractice;
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
 * @property array $weeks
 *
 */
class ProfessionalPracticePlan extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'professional_practice_plan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id'], 'required'],
            [['weeks'], 'default', 'value' => null],
            [['weeks',], 'safe'],
            [['group_id', 'practice_id'], 'integer'],
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
            'weeks' => Yii::t('app', 'Недели'),
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
        return $this->hasOne(ProfessionalPractice::class, ['id' => 'practice_id']);
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
        return $this->hours[1] + $this->hours[2];
    }

    public function types()
    {
    	$types = [
                '6' => 'Технологическая', 
                '7' => 'Производственная',
            ];

        return $types;
    }

    public function type()
    {
    	$types = $this->types();

    	return $types[$this->type];
    }

}
