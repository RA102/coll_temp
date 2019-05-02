<?php

namespace common\models\educational_process;

use common\helpers\ApplicationHelper;
use common\models\person\Entrant;
use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "educational_process.application".
 *
 * @property int $id
 * @property int $status
 * @property int $type
 * @property int $institution_id
 * @property int $person_id
 * @property array $properties
 * @property bool $is_deleted
 * @property string $delete_ts
 * @property string $create_ts
 * @property string $update_ts
 * @property string $reason
 * @property array $history
 * @property Person $person
 */
class AdmissionApplication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'educational_process.application';
    }

    /**
     * @param int $institution_id
     * @param array $properties
     * @return AdmissionApplication
     */
    public static function add(int $institution_id, array $properties)
    {
        $model = new self();
        $model->institution_id = $institution_id;
        $model->properties = $properties;
        $model->type = ApplicationHelper::APPLICATION_TYPE_ADMISSION;
        $model->status = ApplicationHelper::STATUS_CREATED;
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'institution_id', 'person_id', 'type'], 'default', 'value' => null],
            [['status', 'institution_id', 'person_id', 'type'], 'integer'],
            [['institution_id', 'status', 'type'], 'required'],
            [['is_deleted'], 'default', 'value' => false],
            [['is_deleted'], 'boolean'],
            [['delete_ts', 'create_ts', 'update_ts', 'properties', 'history'], 'safe'],
            [['reason'], 'string'],
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
                    'status'    => $this->status,
                    'timestamp' => time()
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
            'type'           => Yii::t('app', 'Type'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'person_id'      => Yii::t('app', 'Person ID'),
            'is_deleted'     => Yii::t('app', 'Is Deleted'),
            'delete_ts'      => Yii::t('app', 'Delete Ts'),
            'create_ts'      => Yii::t('app', 'Create Ts'),
            'update_ts'      => Yii::t('app', 'Update Ts'),
            'reason'         => Yii::t('app', 'Reason'),
            'history'        => Yii::t('app', 'History')
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
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }
}
