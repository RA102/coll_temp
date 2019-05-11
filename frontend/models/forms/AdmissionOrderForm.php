<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * Форма приказа о зачислении
 *
 * @property integer $protocol_number       - Номер приказа
 * @property string  $date                  - Дата приказа
 * @property integer $education_pay_form    - Отделение (бюджет, договор)
 * @property integer $education_form        - Форма обучения
 * @property string  $language    - Язык привязанного предмета в формате ISO (ru kz)
 * @property integer $based_classes         - На базе какого класса поступает
 * @property integer $exam_form             - Форма вступительного экзамена
 */
class AdmissionOrderForm extends Model
{
    public $protocol_number;
    public $date;
    public $education_pay_form;
    public $education_form;
    public $language;
    public $based_classes;
    public $exam_form;

    /**
     * @return array|mixed
     */
    public function rules()
    {
        return [
            [
                [
                    'protocol_number',
                    'date',
                    'education_pay_form',
                    'education_form',
                    'language',
                    'based_classes',
                    'exam_form',
                ],
                'required',
            ],
            [
                [
                    'protocol_number',
                ],
                'string',
            ],
            [
                [
                    'language',
                ],
                'string',
                'max' => 2
            ],
            [
                [
                    'education_pay_form',
                    'education_form',
                    'based_classes',
                    'exam_form',
                ],
                'integer',
            ],
            [
                [
                    'date',
                ],
                'date',
                'format' => 'php:Y-m-d'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'date' => Yii::t('app', 'Date'),
            'protocol_number' => Yii::t('app', 'Protocol number'),
            'education_pay_form' => Yii::t('app', 'Форма оплаты'),
            'education_form' => Yii::t('app', 'Основа обучения'),
            'language' => Yii::t('app', 'Language'),
            'based_classes' => Yii::t('app', 'На базе'),
            'exam_form' => Yii::t('app', 'Exam form'),
        ];
    }
}
