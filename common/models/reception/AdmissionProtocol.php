<?php

namespace common\models\reception;

use Yii;

/**
 * This is the model class for table "reception.admission_protocol".
 *
 * @property int $id
 * @property int $commission_id
 * @property string $number
 * @property string $completion_date
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class AdmissionProtocol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.admission_protocol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commission_id', 'status'], 'default', 'value' => null],
            [['commission_id', 'status'], 'integer'],
            [['completion_date', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['number'], 'string', 'max' => 65],
            [['commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Commission::className(), 'targetAttribute' => ['commission_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'commission_id' => Yii::t('app', 'Commission ID'),
            'number' => Yii::t('app', 'Number'),
            'completion_date' => Yii::t('app', 'Completion Date'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
