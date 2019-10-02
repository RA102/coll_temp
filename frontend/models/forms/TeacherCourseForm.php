<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

class TeacherCourseForm extends Model
{
    public $teacher_id;
    public $group_ids;
    public $type;
    public $start_ts;
    public $end_ts;
    public $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'start_ts', 'end_ts'], 'required'],
            [['type'], 'string', 'max' => 255],
            [['status'], 'integer'],
            [['group_ids'], 'each', 'rule' => ['integer']],
            [['group_ids'], 'required'],
            [['start_ts', 'end_ts'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'teacher_id' => Yii::t('app', 'Teacher ID'),
            'group_ids' => Yii::t('app', 'Groups'),
            'type' => 'Способ',
            'start_ts' => Yii::t('app', 'Teacher Course Start TS'),
            'end_ts' => Yii::t('app', 'Teacher Course End TS'),
            'status' => Yii::t('app', 'Тип'),
        ];
    }
}
