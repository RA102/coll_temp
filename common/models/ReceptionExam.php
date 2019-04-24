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
 * @property InstitutionDiscipline $institutionDiscipline
 * @property ReceptionGroup[] $receptionGroups
 */
class ReceptionExam extends \yii\db\ActiveRecord
{
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
            [['institution_discipline_id'], 'required'],
            [['institution_discipline_id', 'teacher_id'], 'default', 'value' => null],
            [['institution_discipline_id', 'teacher_id'], 'integer'],
            [['date_ts'], 'safe'],
            [['institution_discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstitutionDiscipline::class, 'targetAttribute' => ['institution_discipline_id' => 'id']],
            [['commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Commission::class, 'targetAttribute' => ['commission_id' => 'id']],
        ];
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
            'date_ts' => Yii::t('app', 'Date Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDiscipline()
    {
        return $this->hasOne(InstitutionDiscipline::class, ['id' => 'institution__discipline_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionGroups()
    {
        return $this->hasMany(ReceptionGroup::class, ['id' => 'group_id'])->viaTable('reception.exam_group_link', ['exam_id' => 'id']);
    }
}
