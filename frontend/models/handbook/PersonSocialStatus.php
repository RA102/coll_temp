<?php

namespace app\models\handbook;

use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "handbook.person_social_status".
 *
 * @property array $caption
 * @property string $name
 * @property ArrayExpression $type
 * @property ArrayExpression $grouping
 * @property string $create_ts
 * @property bool $is_deleted
 * @property int $oid
 * @property int $server_id
 */
class PersonSocialStatus extends \yii\db\ActiveRecord
{
    public $caption_current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'handbook.person_social_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'create_ts'], 'safe'],
            [['name', 'type'], 'required'],
            [['type', 'grouping', 'oid', 'server_id'], 'default', 'value' => null],
            [['type', 'grouping', 'oid', 'server_id'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'caption'    => Yii::t('app', 'Caption'),
            'name'       => Yii::t('app', 'Name'),
            'type'       => Yii::t('app', 'Type'),
            'grouping'   => Yii::t('app', 'Grouping'),
            'create_ts'  => Yii::t('app', 'Create Ts'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'oid'        => Yii::t('app', 'Oid'),
            'server_id'  => Yii::t('app', 'Server ID'),
        ];
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage];

        parent::afterFind();
    }
}
