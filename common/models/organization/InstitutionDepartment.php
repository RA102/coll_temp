<?php

namespace common\models\organization;

use common\helpers\SchemeHelper;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "organization.institution_department".
 *
 * @property int $id
 * @property int $institution_id
 * @property array $caption

 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Institution $institution
 */
class InstitutionDepartment extends \yii\db\ActiveRecord
{
    public $caption_current;
    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::ORGANIZATION . 'institution_department';
    }

    public function afterFind()
    {
        parent::afterFind();

        $currentLanguage = \Yii::$app->language == 'kz-KZ' ? 'kk' : 'ru';
        $this->caption_current = $this->caption[$currentLanguage] ?? $this->caption['ru'];
        $this->caption_ru = $this->caption['ru'];
        $this->caption_kk = $this->caption['kk'];
    }

    public function beforeSave($insert)
    {
        $this->caption = [
            'ru' => $this->caption_ru,
            'kk' => $this->caption_kk,
        ];

        return parent::beforeSave($insert);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['institution_id'], 'required'],
            [['institution_id'], 'default', 'value' => null],
            [['institution_id'], 'integer'],
            [['institution_id'], 'exist', 'skipOnError' => true, 'targetClass' => Institution::class, 'targetAttribute' => ['institution_id' => 'id']],
            //[['slug'], 'string', 'max' => 255],
            [['caption_ru', 'caption_kk'], 'string'],
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
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            //'slug' => Yii::t('app', 'Slug'),
            //'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
            'discipline_id' => Yii::t('app', 'Discipline'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitution()
    {
        return $this->hasOne(Institution::class, ['id' => 'institution_id']);
    }

    /**
     * @deprecated
     * @return \yii\db\ActiveQuery
     */

      public function getDisciplines()
    {
        return $this->hasMany(InstitutionDiscipline::class, ['department_id' => 'id']);
    }

    public function saveDisciplines($discipline_id)
    {
        $arr = ArrayHelper::map($this->disciplines, 'id', 'id');
        foreach ($discipline_id as $one)
        {
            if(!in_array($one,$arr)){
                $model = InstitutionDiscipline::findOne($one);
                $this->link('disciplines', $model);
            }
        }

//            if(isset($arr[$one])){
//                $model = InstitutionDiscipline::findOne($one);
//                $model->department_id = null;
//                return $model->save();
//                unset($arr[$one]);
//            }


    }
}
