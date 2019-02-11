<?php

namespace common\models;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "discipline".
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
 */
class Discipline extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption'], 'safe'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['slug'], 'string', 'max' => 255],
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

    public static function add($caption)
    {
        $model = new static;
        $model->caption = $caption;
        $model->status = self::STATUS_ACTIVE;

        return $model;
    }
}
