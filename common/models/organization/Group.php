<?php

namespace common\models\organization;

use common\models\handbook\Speciality;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "organization.group".
 *
 * @property int $id
 * @property array $caption
 * @property string $language
 * @property int $speciality_id
 * @property int $max_class
 * @property int $class
 * @property int $education_form
 * @property int $education_pay_form
 * @property int $institution_id
 * @property int $parent_id
 * @property int $type
 * @property int $rating_system_id
 * @property int $based_classes
 * @property array $class_change_history
 * @property array $properties
 * @property bool $is_deleted
 * @property string $start_ts
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 */
class Group extends \yii\db\ActiveRecord
{
    public $caption_current;

    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization.group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'class_change_history', 'properties', 'start_ts', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['speciality_id', 'max_class', 'class', 'education_form', 'education_pay_form', 'institution_id', 'parent_id', 'type', 'rating_system_id', 'based_classes'], 'default', 'value' => null],
            [['speciality_id', 'max_class', 'class', 'education_form', 'education_pay_form', 'institution_id', 'parent_id', 'type', 'rating_system_id', 'based_classes'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['language'], 'string', 'max' => 2],
            [['caption_ru', 'caption_kk'], 'safe'],
            [['speciality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speciality::className(), 'targetAttribute' => ['speciality_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            'language' => Yii::t('app', 'Language'),
            'speciality_id' => Yii::t('app', 'Speciality ID'),
            'max_class' => Yii::t('app', 'Max Class'),
            'class' => Yii::t('app', 'Class'),
            'education_form' => Yii::t('app', 'Education Form'),
            'education_pay_form' => Yii::t('app', 'Education Pay Form'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'type' => Yii::t('app', 'Type'),
            'rating_system_id' => Yii::t('app', 'Rating System ID'),
            'based_classes' => Yii::t('app', 'Based Classes'),
            'class_change_history' => Yii::t('app', 'Class Change History'),
            'properties' => Yii::t('app', 'Properties'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'start_ts' => Yii::t('app', 'Start Ts'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
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
        $this->caption_ru = $this->caption['ru'];
        $this->caption_kk = $this->caption['kk'];

        parent::afterFind();
    }
}
