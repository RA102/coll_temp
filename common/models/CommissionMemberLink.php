<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "link.commission_member_link".
 *
 * @property int $id
 * @property int $commission_id
 * @property int $member_id
 * @property int $role
 * @property string $create_ts
 * @property string $delete_ts
 */
class CommissionMemberLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.commission_member_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commission_id', 'member_id'], 'required'],
            [['commission_id', 'member_id', 'role'], 'default', 'value' => null],
            [['commission_id', 'member_id', 'role'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
            [['member_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonPerson::className(), 'targetAttribute' => ['member_id' => 'id']],
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
            'commission_id' => Yii::t('app', 'Commission ID'),
            'member_id' => Yii::t('app', 'Member ID'),
            'role' => Yii::t('app', 'Role'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
