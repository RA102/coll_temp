<?php

namespace common\models\organization;

use Yii;

/**
 * This is the model class for table "organization.educational_form".
 *
 * @property int $id
 * @property string $name
 * @property array $caption
 * @property int $status
 * @property bool $is_deleted
 * @property string $create_ts
 * @property int $oid
 * @property string $update_ts
 * @property string $delete_ts
 */
class EducationalForm extends \yii\db\ActiveRecord
{
    public $caption_current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.educational_form';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['status', 'oid'], 'default', 'value' => null],
            [['status', 'oid'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'caption' => Yii::t('app', 'Caption'),
            'status' => Yii::t('app', 'Status'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'oid' => Yii::t('app', 'Oid'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage];

        parent::afterFind();
    }
}
