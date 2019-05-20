<?php

namespace app\models\link;

use common\models\person\Entrant;
use common\models\ReceptionGroup;
use Yii;

/**
 * This is the model class for table "{{%link.entrant_reception_group_link}}".
 *
 * @property int $id
 * @property int $entrant_id
 * @property int $reception_group_id
 * @property string $create_ts
 * @property string $delete_ts
 *
 * @property Entrant $entrant
 * @property ReceptionGroup $receptionGroup
 */
class EntrantReceptionGroupLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.entrant_reception_group_link';
    }

    /**
     * @param int $entrant_id
     * @param int $reception_group_id
     * @return EntrantReceptionGroupLink
     */
    public static function add(int $entrant_id, int $reception_group_id): self
    {
        $model = new self();
        $model->entrant_id = $entrant_id;
        $model->reception_group_id = $reception_group_id;
        return $model;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entrant_id', 'reception_group_id'], 'required'],
            [['entrant_id', 'reception_group_id'], 'default', 'value' => null],
            [['entrant_id', 'reception_group_id'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
            [
                ['entrant_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Entrant::className(),
                'targetAttribute' => ['entrant_id' => 'id']
            ],
            [
                ['reception_group_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => ReceptionGroup::className(),
                'targetAttribute' => ['reception_group_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'entrant_id'         => Yii::t('app', 'Entrant ID'),
            'reception_group_id' => Yii::t('app', 'Reception Group ID'),
            'create_ts'          => Yii::t('app', 'Create Ts'),
            'delete_ts'          => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntrant()
    {
        return $this->hasOne(Entrant::class, ['id' => 'entrant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceptionGroup()
    {
        return $this->hasOne(ReceptionGroup::class, ['id' => 'reception_group_id']);
    }
}
