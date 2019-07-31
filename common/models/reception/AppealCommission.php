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
 *
 * @property Commission $commission
 */
class AppealCommission extends \yii\db\ActiveRecord
{
    public $caption_current;

    public $caption_ru;
    public $caption_kk;

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
            [['caption', 'from_date', 'to_date', 'order_date', 'create_ts', 'update_ts', 'delete_ts', 'caption_ru', 'caption_kk'], 'safe'],
            [['commission_id'], 'default', 'value' => null],
            [['commission_id'], 'integer'],
            [['order_number'], 'string', 'max' => 255],
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
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            'from_date' => Yii::t('app', 'Commission From Date'),
            'to_date' => Yii::t('app', 'Commission To Date'),
            'commission_id' => Yii::t('app', 'Commission ID'),
            'order_number' => Yii::t('app', 'Order Number'),
            'order_date' => Yii::t('app', 'Order Date'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function beforeSave($insert)
    {
        $this->caption = [
            'ru' => $this->caption_ru,
            'kk' => $this->caption_kk,
        ];

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'];
        $this->caption_ru = $this->caption['ru'];
        $this->caption_kk = $this->caption['kk'];

        parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommission()
    {
        return $this->hasOne(Commission::class, ['id' => 'commission_id']);
    }
}
