<?php

namespace common\models;

use common\helpers\SchemeHelper;
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
 */
class Discipline extends \yii\db\ActiveRecord
{
    const TYPE_STANDARD = 1; // эталонный
    const TYPE_OPTIONAL = 2; // необязательный
    const TYPE_ELECTIVE = 3; // факультатив
    const TYPE_ENT = 4; // предметы для ент
    const TYPE_EXAM = 5; // экзаменационные

    const STATUS_ACTIVE = 1;

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

    public static function add($caption, $types)
    {
        $model = new static;
        $model->caption = $caption;
        $model->types = $types;
        $model->status = self::STATUS_ACTIVE;

        return $model;
    }
}
