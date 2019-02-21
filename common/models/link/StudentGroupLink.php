<?php

namespace common\models\link;

use common\models\organization\Group;
use common\models\person\Person;
use Yii;

/**
 * This is the model class for table "link.student_group_link".
 *
 * @property int $id
 * @property int $student_id
 * @property int $group_id
 * @property string $create_ts
 * @property string $delete_ts
 */
class StudentGroupLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link.student_group_link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'group_id'], 'required'],
            [['student_id', 'group_id'], 'default', 'value' => null],
            [['student_id', 'group_id'], 'integer'],
            [['create_ts', 'delete_ts'], 'safe'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['group_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'group_id' => Yii::t('app', 'Group'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'delete_ts' => Yii::t('app', 'Delete Ts'),
        ];
    }
}
