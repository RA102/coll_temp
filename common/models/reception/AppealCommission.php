<?php

namespace common\models\reception;

use Yii;

/**
 * This is the model class for table "reception.appeal_commission".
 *
 * @property int $id
 * @property array $caption
 * @property int $commission_id
 * @property string $from_date
 * @property string $to_date
 * @property string $order_number
 * @property string $order_date
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class AppealCommission extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.appeal_commission';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'from_date', 'to_date', 'order_date', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['commission_id'], 'default', 'value' => null],
            [['commission_id'], 'integer'],
            [['order_number'], 'string', 'max' => 255],
            [['commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReceptionCommission::className(), 'targetAttribute' => ['commission_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'caption' => Yii::t('app', 'Caption'),
            'commission_id' => Yii::t('app', 'Commission ID'),
            'from_date' => Yii::t('app', 'From Date'),
            'to_date' => Yii::t('app', 'To Date'),
            'order_number' => Yii::t('app', 'Order Number'),
            'order_date' => Yii::t('app', 'Order Date'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
