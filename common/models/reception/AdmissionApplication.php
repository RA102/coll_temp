<?php

namespace common\models\reception;

use common\helpers\ApplicationHelper;
use common\models\organization\Institution;
use common\models\person\Entrant;
use common\models\person\Person;
use common\models\person\Student;
use Yii;

/**
 * This is the model class for table "reception.admission_application".
 *
 * @property int $id
 * @property int $status
 * @property array $receipt
 * @property int $institution_id
 * @property int $commission_id
 * @property int $person_id
 * @property array $properties
 * @property bool $is_deleted
 * @property string $delete_ts
 * @property string $create_ts
 * @property string $update_ts
 * @property string $reason
 * @property array $history
 *
 * @property Entrant $person
 * @property Student $student
 * @property Institution $institution
 */
class AdmissionApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.admission_application';
    }

    /**
     * @param int $institution_id
     * @param int $commission_id
     * @param array $properties
     * @return AdmissionApplication
     */
    public static function add(int $commission_id, int $institution_id, int $person_id, array $properties)
    {
        $model = new self();
        $model->commission_id = $commission_id;
        $model->institution_id = $institution_id;
        
        if ($person_id>0) {
            $model->person_id = $person_id;
        }
        
        $model->properties = $properties;
        $model->online = $properties['online'];
        $model->online_msg_id = $properties['online_msg_id'];

        $model->status = ApplicationHelper::STATUS_CREATED;
        $model->is_deleted = false;
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'commission_id', 'institution_id', 'person_id'], 'default', 'value' => null],
            [['status', 'commission_id', 'institution_id', 'person_id', 'online'], 'integer'],
            [['commission_id', 'institution_id', 'status'], 'required'],
            [['is_deleted'], 'default', 'value' => false],
            [['is_deleted'], 'boolean'],
            [['delete_ts', 'create_ts', 'update_ts', 'properties', 'history', 'receipt'], 'safe'],
            [['reason', 'online_msg_id'], 'string'],

            [
                'commission_id',
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Commission::class,
                'targetAttribute' => ['commission_id' => 'id']
            ],
            [
                'institution_id',
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Institution::class,
                'targetAttribute' => ['institution_id' => 'id']
            ],
            [
                'person_id',
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Person::class,
                'targetAttribute' => ['person_id' => 'id']
            ],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($insert || $this->isAttributeChanged('status')) {
            if (!$this->history) {
                $this->history = [];
            }

            $this->history = array_merge($this->history, [
                [
                    'status' => $this->status,
                    'date'   => date("Y-m-d H:i:s")
                ]
            ]);
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'status'         => Yii::t('app', 'Status'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'person_id'      => Yii::t('app', 'Person ID'),
            'is_deleted'     => Yii::t('app', 'Is Deleted'),
            'delete_ts'      => Yii::t('app', 'Delete Ts'),
            'create_ts'      => Yii::t('app', 'Create Ts'),
            'update_ts'      => Yii::t('app', 'Update Ts'),
            'reason'         => Yii::t('app', 'Reason'),
            'history'        => Yii::t('app', 'History'),
            'online'        => Yii::t('app', 'Онлайн'),
        ];
    }

    /**
     *
     */
    public function afterFind()
    {
        parent::afterFind();
        if (!$this->person_id) {
            $entrant = Entrant::add(
                null,
                $this->properties['firstname'],
                $this->properties['lastname'],
                $this->properties['middlename'],
                $this->properties['iin']
            );
            $entrant->setAttributes(($this->properties));
            $this->populateRelation('person', $entrant);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        if ($this->isEnlisted()) {
            return $this->hasOne(Person::class, ['id' => 'person_id']);
        }
        return $this->hasOne(Entrant::class, ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    /**
     * @return bool
     */
    public function isAccepted(): bool
    {
        return $this->status === ApplicationHelper::STATUS_ACCEPTED;
    }

    /**
     * @return bool
     */
    public function isEnlisted(): bool
    {
        return $this->status === ApplicationHelper::STATUS_ENLISTED;
    }
}
