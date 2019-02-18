<?php

namespace common\models\link;

use common\models\organization\Institution;
use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "link.person_institution_link".
 *
 * @property int $id
 * @property int $person_id
 * @property int $institution_id
 * @property string $from_ts
 * @property string $to_ts
 * @property int $status
 * @property string $person_type
 * @property int $index
 * @property bool $is_deleted
 * @property string $create_ts
 * @property string $position
 * @property string $document_submission_date
 * @property string $comment
 * @property int $condition
 * @property int $unfasten_reason_id
 * @property bool $is_pluralist
 * @property string $import_ts
 * @property int $document_number
 *
 * @property Person $$person
 */
class PersonInstitutionLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.person_institution_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'institution_id', 'status', 'index', 'condition', 'unfasten_reason_id', 'document_number'], 'default', 'value' => null],
            [['person_id', 'institution_id', 'status', 'index', 'condition', 'unfasten_reason_id', 'document_number'], 'integer'],
            [['from_ts', 'to_ts', 'create_ts', 'document_submission_date', 'import_ts'], 'safe'],
            [['is_deleted', 'is_pluralist'], 'boolean'],
            [['person_type', 'position'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 255],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::className(), 'targetAttribute' => ['institution_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'person_id' => Yii::t('app', 'Person ID'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'from_ts' => Yii::t('app', 'From Ts'),
            'to_ts' => Yii::t('app', 'To Ts'),
            'status' => Yii::t('app', 'Status'),
            'person_type' => Yii::t('app', 'Person Type'),
            'index' => Yii::t('app', 'Index'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'position' => Yii::t('app', 'Position'),
            'document_submission_date' => Yii::t('app', 'Document Submission Date'),
            'comment' => Yii::t('app', 'Comment'),
            'condition' => Yii::t('app', 'Condition'),
            'unfasten_reason_id' => Yii::t('app', 'Unfasten Reason ID'),
            'is_pluralist' => Yii::t('app', 'Is Pluralist'),
            'import_ts' => Yii::t('app', 'Import Ts'),
            'document_number' => Yii::t('app', 'Document Number'),
        ];
    }

    public static function add($person_id, $institution_id)
    {
        $model = new self();
        $model->person_id = $person_id;
        $model->institution_id = $institution_id;

        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::class, ['id' => 'person_id']);
    }
}
