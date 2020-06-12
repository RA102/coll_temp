<?php

namespace frontend\models\rup;

use Yii;

/**
 * This is the model class for table "rup_qualifications".
 *
 * @property int $id
 * @property string $qualification_name
 * @property int $time_years
 * @property int $time_months
 * @property int $rup_id
 * @property int $qualification_code
 */
class RupQualifications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rup_qualifications';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qualification_name', 'time_years', 'time_months', 'rup_id'], 'required'], //, 'qualification_code'
            [['time_years', 'time_months', 'rup_id', 'qualification_code'], 'default', 'value' => null],
            [['rup_id', 'qualification_code'], 'integer'],
            [['time_years'], 'integer', 'max'=>5],
            [['time_months'], 'integer', 'max'=>11],
            [['qualification_name', 'q_level'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qualification_name' => 'Наименование',
            'time_years' => 'Количество лет',
            'time_months' => 'Количество месяцев',
            'rup_id' => 'Rup ID',
            'qualification_code' => 'Код',
        ];
    }

}
