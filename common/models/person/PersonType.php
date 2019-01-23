<?php

namespace common\models\person;

use Yii;

/**
 * This is the model class for table "{{%person.person_type}}".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $home_page
 * @property int $group
 * @property int $oid
 * @property bool $is_deleted
 * @property string $create_ts
 * @property int $priority
 * @property int $action
 * @property array $caption
 */
class PersonType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%person.person_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'group'], 'required'],
            [['parent_id', 'group', 'oid', 'priority', 'action'], 'default', 'value' => null],
            [['parent_id', 'group', 'oid', 'priority', 'action'], 'integer'],
            [['is_deleted'], 'boolean'],
            [['create_ts', 'caption'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['home_page'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'home_page' => Yii::t('app', 'Home Page'),
            'group' => Yii::t('app', 'Group'),
            'oid' => Yii::t('app', 'Oid'),
            'is_deleted' => Yii::t('app', 'Is Deleted'),
            'create_ts' => Yii::t('app', 'Create Ts'),
            'priority' => Yii::t('app', 'Priority'),
            'action' => Yii::t('app', 'Action'),
            'caption' => Yii::t('app', 'Caption'),
        ];
    }

    public function fields()
    {
        return [
            'name',
            'parent_id',
            'caption'
        ];
    }
}
