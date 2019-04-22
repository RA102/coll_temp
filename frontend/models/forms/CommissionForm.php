<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

class CommissionForm extends Model
{
    public $caption_ru;
    public $caption_kk;
    public $from_date;
    public $to_date;
    public $order_number;
    public $order_date;
    public $exam_start_date;
    public $exam_end_date;
    public $institution_discipline_ids;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_date', 'to_date', 'exam_start_date', 'exam_end_date'], 'required'],
            [['from_date', 'to_date', 'order_number', 'order_date', 'exam_start_date', 'exam_end_date'], 'string'],
            [['caption_ru', 'caption_kk'], 'required'],
            [['caption_ru', 'caption_kk'], 'string'],
            [['institution_discipline_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'from_date' => Yii::t('app', 'Commission From Date'),
            'to_date' => Yii::t('app', 'Commission To Date'),
            'order_number' => Yii::t('app', 'Commission Order Number'),
            'order_date' => Yii::t('app', 'Commission Order Date'),
            'exam_start_date' => Yii::t('app', 'Exam Start Date'),
            'exam_end_date' => Yii::t('app', 'Exam End Date'),
            'institution_discipline_ids' => Yii::t('app', 'Institution Disciplines'),
        ];
    }
}
