<?php

namespace common\models\link;

use common\models\organization\InstitutionDiscipline;
use common\models\reception\Commission;
use Yii;

/**
 * This is the model class for table "link.commission_discipline_link".
 *
 * @property int $id
 * @property int $commission_id
 * @property int $institution_discipline_id
 */
class CommissionDisciplineLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.commission_discipline_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['commission_id', 'institution_discipline_id'], 'required'],
            [['commission_id', 'institution_discipline_id'], 'default', 'value' => null],
            [['commission_id', 'institution_discipline_id'], 'integer'],
            [['institution_discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => InstitutionDiscipline::class, 'targetAttribute' => ['institution_discipline_id' => 'id']],
            [['commission_id'], 'exist', 'skipOnError' => true, 'targetClass' => Commission::class, 'targetAttribute' => ['commission_id' => 'id']],
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
            'institution_discipline_id' => Yii::t('app', 'Institution Discipline ID'),
        ];
    }
}
