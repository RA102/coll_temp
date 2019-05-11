<?php

namespace frontend\models\reception\admission_application;

use yii\base\Model;

class ReceiptForm extends Model
{
    public $applications_count;
    public $school_certificates_count;
    public $medical_certificates_count;
    public $medical_commission_opinions_count;
    public $photos_count;
    public $ent_certificates_count;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                [
                    'applications_count',
                    'school_certificates_count',
                    'medical_certificates_count',
                    'medical_commission_opinions_count',
                    'photos_count',
                    'ent_certificates_count',
                ],
                'integer',
                'min' => 0,
                'max' => 10
            ]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'applications_count'                => \Yii::t('app', 'Заявление в колледж'),
            'school_certificates_count'         => \Yii::t('app', 'Подлинник документа об образовании'),
            'medical_certificates_count'        => \Yii::t('app',
                'Медицинская справка по форме № 086- У с приложением флюроснимка'),
            'medical_commission_opinions_count' => \Yii::t('app',
                'Заключение медико-социальной экспертной комиссии (для инвалидов I и II группы и инвалидов детства)'),
            'photos_count'                      => \Yii::t('app', 'Фотокарточка 3x4 см'),
            'ent_certificates_count'            => \Yii::t('app', 'Сертификат ЕНТ'),
        ];
    }
}