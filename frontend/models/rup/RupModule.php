<?php

namespace frontend\models\rup;

use Yii;

/**
 * This is the model class for table "rup_module".
 *
 * @property int $id
 * @property int $year
 * @property int $status
 * @property string $create
 * @property string $update_ts
 * @property string $caption_ru
 * @property string $caption_kz
 * @property string $profession_code
 * @property int $study_form
 * @property int $profile_id
 * @property int $spec_id
 * @property int $level_id
 * @property int $study_time
 */
class RupModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rup_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'status', 'create', 'update_ts', 'caption_ru', 'caption_kz', 'profession_code', 'study_form', 'profile_id', 'spec_id', 'level_id', 'study_time'], 'required'],
            [['year', 'status', 'study_form', 'profile_id', 'spec_id', 'level_id', 'study_time'], 'default', 'value' => null],
            [['year', 'status', 'study_form', 'profile_id', 'spec_id', 'level_id', 'study_time'], 'integer'],
            [['create', 'update_ts'], 'safe'],
            [['caption_ru', 'caption_kz'], 'string', 'max' => 300],
            [['profession_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'status' => 'Status',
            'create' => 'Create',
            'update_ts' => 'Update Ts',
            'caption_ru' => 'Caption Ru',
            'caption_kz' => 'Caption Kz',
            'profession_code' => 'Profession Code',
            'study_form' => 'Study Form',
            'profile_id' => 'Profile ID',
            'spec_id' => 'Spec ID',
            'level_id' => 'Level ID',
            'study_time' => 'Study Time',
        ];
    }
}
