<?php

namespace common\models\reception;

use common\helpers\AppealApplicationHelper;
use common\models\person\Entrant;
use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "reception.appeal_application".
 *
 * @property int $id
 * @property int $appeal_commission_id
 * @property int $entrant_id
 * @property string $reason
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Entrant $entrant
 */
class AppealApplication extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_REJECTED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.appeal_application';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appeal_commission_id', 'entrant_id', 'status'], 'default', 'value' => null],
            [['appeal_commission_id', 'entrant_id', 'status'], 'integer'],
            [['entrant_id', 'reason'], 'required'],
            [['reason'], 'string'],
            [['create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['entrant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['entrant_id' => 'id']],
            [['appeal_commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppealCommission::className(), 'targetAttribute' => ['appeal_commission_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appeal_commission_id' => Yii::t('app', 'Appeal Commission ID'),
            'entrant_id' => Yii::t('app', 'Entrant ID'),
            'reason' => Yii::t('app', 'Reason'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function getEntrant() {
        return $this->hasOne(Entrant::class, ['id' => 'entrant_id']);
    }

    public function getAppealCommission() {
        return $this->hasOne(AppealCommission::class, ['id' => 'appeal_commission_id']);
    }

    public function getStatusValue() {
        return AppealApplicationHelper::getStatusList()[$this->status] ?? null;
    }

    public function isFinished() {
        $finishedStatuses = [self::STATUS_ACCEPTED, self::STATUS_REJECTED];
        return in_array($this->status, $finishedStatuses);
    }
}
