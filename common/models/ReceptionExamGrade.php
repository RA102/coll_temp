<?php

namespace common\models;

use common\helpers\ReceptionExamGradeHelper;
use common\models\person\Entrant;
use Yii;

/**
 * This is the model class for table "reception.exam_grade".
 *
 * @property int $id
 * @property int $entrant_id
 * @property int $exam_id
 * @property int $grade_type
 * @property string $grade
 * @property int $points
 * @property string $history
 * @property string $create_ts
 * @property string $delete_ts
 *
 * @property Entrant $entrant
 * @property ReceptionExam $receptionExam
 * @property string $gradeWrapper
 * @property array $historyWrapper
 */
class ReceptionExamGrade extends \yii\db\ActiveRecord
{
    const GRADE_TYPE_LOGICAL = 1;
    const GRADE_TYPE_TEST = 2;
    const GRADE_TYPE_5 = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.exam_grade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gradeWrapper'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'entrant_id' => Yii::t('app', 'Entrant ID'),
            'exam_id' => Yii::t('app', 'Exam ID'),
            'grade' => Yii::t('app', 'Exam Grade Value'),
            'gradeWrapper' => Yii::t('app', 'Exam Grade Value'),
            'history' => Yii::t('app', 'Exam Grade History'),
            'historyWrapper' => Yii::t('app', 'Exam Grade History'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function setGradeWrapper($value)
    {
        $this->grade = $value;
        $this->points = ReceptionExamGradeHelper::getGradeTypePoints($this->grade_type)[$value];

        $history = $this->historyWrapper;
        $history[] = [
            'date' => date('Y-m-d H:i:s'),
            'value' => $value,
        ];
        $this->historyWrapper = $history;
    }

    public function getGradeWrapper()
    {
        return $this->grade;
    }

    public function getHistoryWrapper()
    {
        $history = json_decode($this->history);
        if ($history !== null) {
            return $history;
        } else {
            return [];
        }
    }

    public function setHistoryWrapper($value)
    {
        $this->history = json_encode($value);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionExam()
    {
        return $this->hasOne(ReceptionExam::class, ['id' => 'exam_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrant()
    {
        return $this->hasOne(Entrant::class, ['id' => 'entrant_id']);
    }

    public static function add(Entrant $entrant, ReceptionExam $receptionExam)
    {
        $model = new static();
        $model->grade_type = $receptionExam->grade_type;
        $model->exam_id = $receptionExam->id;
        $model->entrant_id = $entrant->id;

        return $model;
    }
}
