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
 */
class Discipline extends \yii\db\ActiveRecord
{
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
            [['caption', 'create_ts', 'update_ts', 'delete_ts'], 'safe'],
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
}
