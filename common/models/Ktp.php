<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDiscipline;
use common\models\organization\Group;
use common\models\person\Person;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "public.ktp".
 *
 * @property int $id
 * @property int $intitution_discipline_id
 * @property int $group_id
 * @property int $teacher_id
 * @property array $lessons
 *
 */
class Ktp extends \yii\db\ActiveRecord
{
	public $week;
	public $lesson_number;
	public $lesson_topic;
	public $type;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'ktp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_discipline_id', 'group_id', 'teacher_id'], 'required'],
            [['institution_discipline_id', 'group_id', 'teacher_id'], 'integer'],
            [['lessons'], 'safe'],
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
            'institution_discipline_id' => Yii::t('app', 'Discipline ID'),
            'group_id' => Yii::t('app', 'Group'),
            'teacher_id' => Yii::t('app', 'Teacher'),
            'lessons' => 'Занятия',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(Person::class, ['id' => 'teacher_id']);
    }

    public function types()
    {
    	$types = [
    		'Теоретическое обучение' => [
    			'1' => 'Лекция', 
    			'2' => 'Семинар (ЛПЗ)', 
    			'3' => 'Курсовая работа (проект)',
    			'4' => 'Консультации',
    		],
    		'5' => 'Учебная практика',
    		'Профессиональная практика' => [
    			'6' => 'Технологическая', 
    			'7' => 'Производственная',
    		], 
    		'Промежуточная и итоговая аттестация' => [
    			'8' => 'Контрольная работа',
    			'9' => 'Зачёт',
    			'10' => 'Экзамен',
    		],
    		'11' => 'Написание и защита дипломной работы (проекта)',
    		'12' => 'Факультативные курсы',
    	];

    	return $types;
    }
}
