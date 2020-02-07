<?php

namespace frontend\models\rup;

use Yii;

/**
 * This is the model class for table "handbook.profiles".
 *
 * @property int $id
 * @property string $caption_ru
 * @property string $caption_kz
 * @property int $code
 * @property string $create_ts
 * @property bool $is_deleted
 * @property int $subjects
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'handbook.profiles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['caption_ru', 'caption_kz', 'code', 'create_ts', 'is_deleted', 'subjects'], 'required'],
            [['code', 'subjects'], 'default', 'value' => null],
            [['code', 'subjects'], 'integer'],
            [['create_ts','codecaption'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['caption_ru', 'caption_kz'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'caption_ru' => 'Caption Ru',
            'caption_kz' => 'Caption Kz',
            'code' => 'Code',
            'create_ts' => 'Create Ts',
            'is_deleted' => 'Is Deleted',
            'subjects' => 'Subjects',
        ];
    }

    public function getCodecaption(){
    return $this->code.'-'.$this->caption_ru;
    }
}
