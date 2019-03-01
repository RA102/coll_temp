<?php

namespace common\models\organization;

use Yii;

/**
 * This is the model class for table "organization.institution_type".
 *
 * @property int $id
 * @property array $caption
 * @property int $parent_id
 * @property bool $is_deleted
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class InstitutionType extends \yii\db\ActiveRecord
{
    public $caption_current;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.institution_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['parent_id'], 'default', 'value' => null],
            [['parent_id'], 'integer'],
            [['is_deleted'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'caption' => Yii::t('app', 'Caption'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'];

        parent::afterFind();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id'])->inverseOf('children');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id'])->inverseOf('parent');
    }
}
