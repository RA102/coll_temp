<?php

namespace common\models\reception;

use common\models\link\CommissionMemberLink;
use Yii;
use yii\db\ArrayExpression;
use yii\db\Expression;

/**
 * This is the model class for table "reception.admission_protocol".
 *
 * @property int $id
 * @property int $commission_id
 * @property string $number
 * @property string $completion_date
 * @property int $status
 * @property ArrayExpression $commission_members
 * @property ArrayExpression $agendas
 * @property array $issues
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class AdmissionProtocol extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 1;
    const STATUS_CLOSED = 2;
    const STATUS_DELETED = 3;

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
            [
                ['completion_date', 'create_ts', 'update_ts', 'delete_ts', 'commission_members', 'agendas', 'issues'],
                'safe'
            ],
            [['number'], 'string', 'max' => 65],
            [
                ['commission_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Commission::className(),
                'targetAttribute' => ['commission_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'commission_id'   => Yii::t('app', 'Commission'),
            'number'          => Yii::t('app', 'Number'),
            'completion_date' => Yii::t('app', 'Date of filling'),
            'status'          => Yii::t('app', 'Status'),
            'create_ts'       => Yii::t('app', 'Create Ts'),
            'update_ts'       => Yii::t('app', 'Update Ts'),
            'delete_ts'       => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @param int $commission_id
     * @param string $number
     * @param string $completion_date
     * @param int[] $commission_members
     * @param string[] $agendas
     * @return AdmissionProtocol
     */
    public static function add(
        int $commission_id,
        string $number,
        string $completion_date,
        array $commission_members,
        array $agendas
    ): self {
        $model = new self();
        $model->commission_id = $commission_id;
        $model->number = $number;
        $model->completion_date = $completion_date;
        $model->commission_members = $commission_members;
        $model->agendas = $agendas;
        $model->status = self::STATUS_CREATED;
        return $model;
    }

    /**
     * @return array
     */
    public static function getStatusLabels(): array
    {
        return [
            self::STATUS_CREATED => Yii::t('app', 'Active'),
            self::STATUS_CLOSED  => Yii::t('app', 'Closed'),
            self::STATUS_DELETED => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusLabel(): string
    {
        return self::getStatusLabels()[$this->status];
    }

    /**
     * @return CommissionMemberLink[]
     */
    public function getCommissionMemberLinks()
    {
        return CommissionMemberLink::find()->innerJoinWith('member')
            ->where(['member_id' => $this->commission_members])
            ->all();
    }

    /**
     *
     */
    public function delete()
    {
        $this->status = AdmissionProtocol::STATUS_DELETED;
        $this->delete_ts = new Expression('NOW()');
    }

    /**
     * @return bool
     */
    public function isCreated(): bool
    {
        return $this->status === self::STATUS_CREATED;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->status === self::STATUS_CLOSED;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->status === self::STATUS_DELETED;
    }
}
