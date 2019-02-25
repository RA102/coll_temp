<?php

namespace common\models;

use common\helpers\SchemeHelper;
use common\models\organization\InstitutionDiscipline;
use Yii;
use yii\db\ArrayExpression;

/**
 * This is the model class for table "discipline".
 *
 * @property int $id
 * @property array $caption
 * @property string $slug
 * @property int[] $types
 * @property int $status
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 *
 * @property Course[] $courses
 * @property InstitutionDiscipline[] $institutionDisciplines
 */
class Discipline extends \yii\db\ActiveRecord
{
    const TYPE_STANDARD = 1; // эталонный
    const TYPE_OPTIONAL = 2; // необязательный
    const TYPE_ELECTIVE = 3; // факультатив
    const TYPE_ENT = 4; // предметы для ент
    const TYPE_EXAM = 5; // экзаменационные

    const STATUS_ACTIVE = 1;

    public $caption_current;
    public $caption_ru;
    public $caption_kk;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'discipline';
    }

    public function afterFind()
    {
        parent::afterFind();

        if ($this->types instanceof ArrayExpression) {
            $this->types = $this->types->getValue();
        }

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
            [['caption'], 'safe'],
            [['status', 'types'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['slug'], 'string', 'max' => 255],
            [['types'], 'each', 'rule' => ['integer']],
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
            'types' => Yii::t('app', 'Discipline Type'),
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
        return $this->hasMany(Course::class, ['discipline_id' => 'id'])->inverseOf('discipline');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstitutionDisciplines()
    {
        return $this->hasMany(InstitutionDiscipline::class, ['discipline_id' => 'id']);
    }

    public static function add($caption, $types)
    {
        $model = new static;
        $model->caption = $caption;
        $model->types = $types;
        $model->status = self::STATUS_ACTIVE;

        return $model;
    }
}
