<?php

namespace common\models\handbook;

use Yii;

/**
 * This is the model class for table "handbook.speciality".
 *
 * @property int $id
 * @property int $parent_id
 * @property int $parent_oid
 * @property int $type
 * @property string $code
 * @property array $caption
 * @property string $msko
 * @property string $gkz
 * @property int $server_id
 * @property string $create_ts
 * @property bool $is_deleted
 * @property int $subjects
 * @property bool $is_working
 * @property int $institution_type
 * @property string $caption_current
 *
 * @property Speciality[] $children
 * @property Speciality $parent
 */
class Speciality extends \yii\db\ActiveRecord
{
    const INSTITUTION_TYPE_SPECIALIZED_SECONDARY = 1;
    const INSTITUTION_TYPE_HIGHER = 2;

    public $caption_current;
    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'handbook.speciality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['parent_id', 'parent_oid', 'type', 'server_id', 'subjects', 'institution_type'],
                'default',
                'value' => null
            ],
            [['parent_id', 'parent_oid', 'type', 'server_id', 'subjects', 'institution_type'], 'integer'],
            [['code'], 'string'],
            [['caption', 'create_ts'], 'safe'],
            [['is_deleted', 'is_working'], 'boolean'],
            [['msko', 'gkz'], 'string', 'max' => 100],
            [
                ['parent_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Speciality::className(),
                'targetAttribute' => ['parent_id' => 'id']
            ],
            [['caption_ru', 'caption_kk'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'parent_oid' => Yii::t('app', 'Parent Oid'),
            'type' => Yii::t('app', 'Type'),
            'code' => Yii::t('app', 'Code'),
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption'),
            'msko' => Yii::t('app', 'Msko'),
            'gkz' => Yii::t('app', 'Gkz'),
            'server_id' => Yii::t('app', 'Server ID'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'subjects' => Yii::t('app', 'Subjects'),
            'is_working' => Yii::t('app', 'Is Working'),
            'institution_type' => Yii::t('app', 'Institution Type'),
        ];
    }

    public function getParent()
    {
        return $this->hasOne(Speciality::class, ['id' => 'parent_id'])->inverseOf('children');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Speciality::class, ['parent_id' => 'id'])->inverseOf('parent');
    }

    public function hasChildren()
    {
        return count($this->children) > 0 ? true : false;
    }

    public function beforeSave($insert)
    {
        $this->caption = [
            'ru' => $this->caption_ru,
            'kk' => $this->caption_kk,
        ];

        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'];
        $this->caption_ru = $this->caption['ru'] ?? '';
        $this->caption_kk = $this->caption['kk'] ?? $this->caption['ru'] ?? '';

        parent::afterFind();

    }

    public function getCaptionWithCode() {
        return "{$this->caption_current} ({$this->code})";
    }
}