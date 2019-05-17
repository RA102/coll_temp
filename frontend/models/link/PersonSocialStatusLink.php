<?php

namespace app\models\link;

use Yii;

/**
 * This is the model class for table "link.person_social_status_link".
 *
 * @property int $person_id
 * @property int $social_status_id
 * @property string $create_ts
 * @property bool $is_deleted
 * @property string $delete_ts
 * @property int $index
 * @property string $document_number
 * @property string $comment
 */
class PersonSocialStatusLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.person_social_status_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id', 'social_status_id'], 'required'],
            [['person_id', 'social_status_id'], 'default', 'value' => null],
            [['person_id', 'social_status_id'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
            [['is_deleted'], 'boolean'],
            [['document_number'], 'string', 'max' => 255],
            [['comment'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'person_id'        => Yii::t('app', 'Person ID'),
            'social_status_id' => Yii::t('app', 'Social Status ID'),
            'create_ts'        => Yii::t('app', 'Create Ts'),
            'is_deleted'       => Yii::t('app', 'Is Deleted'),
            'delete_ts'        => Yii::t('app', 'Delete Ts'),
            'index'            => Yii::t('app', 'Index'),
            'document_number'  => Yii::t('app', 'Document Number'),
            'comment'          => Yii::t('app', 'Comment'),
        ];
    }
}
