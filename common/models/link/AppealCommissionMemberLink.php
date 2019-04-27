<?php

namespace common\models\link;

use common\models\person\Person;
use common\models\reception\AppealCommission;
use Yii;

/**
 * This is the model class for table "link.appeal_commission_member_link".
 *
 * @property int $id
 * @property int $appeal_commission_id
 * @property int $member_id
 * @property int $role
 * @property string $create_ts
 * @property string $delete_ts
 */
class AppealCommissionMemberLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.appeal_commission_member_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['appeal_commission_id', 'member_id'], 'required'],
            [['appeal_commission_id', 'member_id', 'role'], 'default', 'value' => null],
            [['appeal_commission_id', 'member_id', 'role'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['member_id' => 'id']],
            [['appeal_commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppealCommission::className(), 'targetAttribute' => ['appeal_commission_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'appeal_commission_id' => Yii::t('app', 'Appeal Commission ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'role' => Yii::t('app', 'Role'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
