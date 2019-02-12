<?php

namespace common\models\organization;

use common\models\Discipline;
use Yii;

/**
 * This is the model class for table "organization.institution_discipline".
 *
 * @property int $id
 * @property int $institution_id
 * @property int $discipline_id
 * @property int $types
 */
class InstitutionDiscipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.institution_discipline';
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
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::className(), 'targetAttribute' => ['institution_id' => 'id']],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'institution_id' => 'Institution ID',
            'discipline_id' => 'Discipline ID',
            'types' => 'Types',
        ];
    }
}
