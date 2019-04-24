<?php

namespace common\models;

use common\helpers\GroupHelper;
use common\helpers\LanguageHelper;
use common\models\handbook\Speciality;
use Yii;

/**
 * This is the model class for table "reception.group".
 *
 * @property int $id
 * @property array $caption
 * @property string $language
 * @property int $speciality_id
 * @property int $education_form
 * @property int $commission_id
 * @property int $budget_places
 * @property int $commercial_places
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Speciality $speciality
 */
class ReceptionGroup extends \yii\db\ActiveRecord
{
    public $caption_current;

    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reception.group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption', 'caption_ru', 'caption_kk', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
            [['speciality_id', 'education_form', 'commission_id', 'budget_places', 'commercial_places'], 'default', 'value' => null],
            [['speciality_id', 'education_form', 'commission_id', 'budget_places', 'commercial_places'], 'integer'],
            [['language'], 'string', 'max' => 2],
            [['speciality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speciality::className(), 'targetAttribute' => ['speciality_id' => 'id']],
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
            'education_form' => Yii::t('app', 'Education Form'),
            'institution_id' => Yii::t('app', 'Institution ID'),
            'budget_places' => Yii::t('app', 'Budget Places'),
            'commercial_places' => Yii::t('app', 'Commercial Places'),
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

    public function getLanguage()
    {
        return LanguageHelper::getLanguageList()[$this->language] ?? '';
    }


    public function getSpeciality()
    {
        return $this->hasOne(Speciality::class, ['id' => 'speciality_id']);
    }

    public function getEducationPayForm()
    {
        return GroupHelper::getEducationFormList()[$this->education_form] ?? '';
    }
}
