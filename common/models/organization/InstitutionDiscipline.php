<?php

namespace common\models\organization;

use common\helpers\SchemeHelper;
use common\models\Discipline;
use Yii;

/**
 * This is the model class for table "organization.institution_discipline".
 *
 * @property int $id
 * @property int $institution_id
 * @property int $discipline_id
 * @property int $types
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class InstitutionDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::ORGANIZATION . 'institution_discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id', 'discipline_id'], 'required'],
            [['institution_id', 'discipline_id', 'types'], 'default', 'value' => null],
            [['institution_id', 'discipline_id', 'types'], 'integer'],
            [['institution_id', 'discipline_id'], 'unique', 'targetAttribute' => ['institution_id', 'discipline_id']],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::class, 'targetAttribute' => ['institution_id' => 'id']],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::class, 'targetAttribute' => ['discipline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'discipline_id' => Yii::t('app', 'Discipline ID'),
            'types' => Yii::t('app', 'Types'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
