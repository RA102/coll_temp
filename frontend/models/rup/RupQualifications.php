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
            [['qualification_name', 'time_years', 'time_months', 'rup_id', 'qualification_code'], 'required'],
            [['time_years', 'time_months', 'rup_id', 'qualification_code'], 'default', 'value' => null],
            [['time_years', 'time_months', 'rup_id', 'qualification_code'], 'integer'],
            [['qualification_name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'qualification_name' => 'Qualification Name',
            'time_years' => 'Time Years',
            'time_months' => 'Time Months',
            'rup_id' => 'Rup ID',
            'qualification_code' => 'Qualification Code',
        ];
    }
}
