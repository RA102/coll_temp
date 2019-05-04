<?php

namespace common\models;

use common\models\organization\InstitutionDiscipline;
use common\models\reception\Commission;
use Yii;

/**
 * This is the model class for table "reception.exam".
 *
 * @property int $id
 * @property int $commission_id
 * @property int $institution_discipline_id
 * @property int $teacher_id
 * @property string $date_ts
 *
 * @property Commission $commission
 * @property InstitutionDiscipline $institutionDiscipline
 * @property ReceptionGroup[] $receptionGroups
 * @property ReceptionExamGrade[] $receptionExamGrades
 */
class ReceptionExam extends \yii\db\ActiveRecord
{
    public $date;
    public $time;
    public $group_ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.exam';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_discipline_id', 'date', 'time'], 'required'],
            [['institution_discipline_id', 'teacher_id'], 'default', 'value' => null],
            [['institution_discipline_id', 'teacher_id'], 'integer'],
            [['date_ts'], function ($attribute) {
                if (($commission = $this->commission) !== null) {
                    if (($this->date < $commission->exam_start_date) || ($this->date > $commission->exam_end_date)){
                        $this->addError($attribute, 'Date not between commission exam dates');
                    }
                }
            }],
            [['institution_discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstitutionDiscipline::class, 'targetAttribute' => ['institution_discipline_id' => 'id']],
            [['commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Commission::class, 'targetAttribute' => ['commission_id' => 'id']],
            [['group_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->date = date('Y-m-d', strtotime($this->date_ts));
        $this->time = date('H:i', strtotime($this->date_ts));
    }

    public function beforeSave($insert)
    {
        if ($this->date && $this->time) {
            $this->date_ts = $this->date . ' ' . $this->time;
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'commission_id' => Yii::t('app', 'Commission'),
            'institution_discipline_id' => Yii::t('app', 'Institution Discipline'),
            'reception_group_ids' => Yii::t('app', 'Reception Groups'),
            'teacher_id' => Yii::t('app', 'Teacher'),
            'date_ts' => Yii::t('app', 'Date TS'),
            'group_ids' => Yii::t('app', 'Groups'),
            'date' => Yii::t('app', 'Exam Date'),
            'time' => Yii::t('app', 'Exam Time'),
        ];
    }

    public function getFullName()
    {
        return $this->institutionDiscipline->caption_current . ' (' . $this->date . ' ' . $this->time . ')';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommission()
    {
        return $this->hasOne(Commission::class, ['id' => 'commission_id']);
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
    public function getReceptionGroups()
    {
        return $this->hasMany(ReceptionGroup::class, ['id' => 'group_id'])->viaTable('reception.exam_group_link', ['exam_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionExamGrades()
    {
        return $this->hasMany(ReceptionExamGrade::class, ['exam_id' => 'id']);
    }
}
