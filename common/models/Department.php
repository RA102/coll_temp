<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDepartment;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "department".
 *
 * @deprecated properties moved to InstitutionDisciline
 *
 * @property int $id
 * @property array $caption
 * @property string $slug
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Course[] $courses
 * @property InstitutionDepartment[] $institutionDepartment
 */
class Department extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    public $caption_current;
    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'department';
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
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['slug'], 'string', 'max' => 255],
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
            'caption' => Yii::t('app', 'Caption'),
            'caption_ru' => Yii::t('app', 'Caption Ru'),
            'caption_kk' => Yii::t('app', 'Caption Kk'),
            'caption_current' => Yii::t('app', 'Caption Current'),
            'slug' => Yii::t('app', 'Slug'),
            'status' => Yii::t('app', 'Status'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'update_ts' => Yii::t('app', 'Update Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::class, ['department_id' => 'id'])->inverseOf('department');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDepartments()
    {
        return $this->hasMany(InstitutionDepartment::class, ['department_id' => 'id']);
    }

    public static function add($caption)
    {
        $model = new static;
        $model->caption = $caption;
        $model->status = self::STATUS_ACTIVE;

        return $model;
    }
}
