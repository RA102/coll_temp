<?php

namespace common\models\organization;

use common\models\handbook\Speciality;
use Yii;

/**
 * This is the model class for table "organization.institution_speciality_info".
 *
 * @property int $id
 * @property int $speciality_id
 * @property int $institution_id
 * @property array $caption
 * @property int $status
 * @property string $create_ts
 * @property bool $is_deleted
 * @property int $default_grade
 * @property int $parent_id
 * @property int $academic_year_id
 * @property int $oid
 * @property int $server_id
 */
class InstitutionSpecialityInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.institution_speciality_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_id', 'institution_id'], 'required'],
            [['speciality_id', 'institution_id', 'status', 'default_grade', 'parent_id', 'academic_year_id', 'oid', 'server_id'], 'default', 'value' => null],
            [['speciality_id', 'institution_id', 'status', 'default_grade', 'parent_id', 'academic_year_id', 'oid', 'server_id'], 'integer'],
            [['caption', 'create_ts'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['speciality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speciality::className(), 'targetAttribute' => ['speciality_id' => 'id']],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::className(), 'targetAttribute' => ['institution_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'speciality_id' => Yii::t('app', 'Speciality ID'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'caption' => Yii::t('app', 'Caption'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'default_grade' => Yii::t('app', 'Default Grade'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'academic_year_id' => Yii::t('app', 'Academic Year ID'),
            'oid' => Yii::t('app', 'Oid'),
            'server_id' => Yii::t('app', 'Server ID'),
        ];
    }
}
