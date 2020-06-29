<?php

namespace app\models\rup;

use Yii;

/**
 * This is the model class for table "rup_roots".
 *
 * @property int $rup_id
 * @property int $rup_year
 * @property int $status
 * @property string $create_ts
 * @property string $delete_ts
 * @property string $lastopen_ts
 * @property string $lastclose_ts
 * @property int $create_userid
 * @property int $delete_userid
 * @property int $lastopen_userid
 * @property int $lastclose_userid
 * @property string $captionRu
 * @property string $captionKz
 * @property string $lang
 * @property string $profile_code
 * @property string $spec_code
 * @property int $edu_form
 */
class RupRoots extends \yii\db\ActiveRecord
{
    
    public const STATUS_CLOSED = 0;
    public const STATUS_OPENED = 1;
    public const STATUS_DELETED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rup_roots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rup_year', 'status', 'create_userid', 'delete_userid', 'lastopen_userid', 'lastclose_userid', 'edu_form'], 'default', 'value' => null],
            [['rup_year', 'status', 'create_userid', 'delete_userid', 'lastopen_userid', 'lastclose_userid', 'edu_form'], 'integer'],
            [['create_ts', 'delete_ts', 'lastopen_ts', 'lastclose_ts'], 'safe'],
            [['captionRu', 'captionKz', 'profile_code', 'spec_code'], 'string', 'max' => 255],
            [['captionRu'],'required'],
            [['captionRu'],'unique'],
            [['lang'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rup_id' => 'Rup ID',
            'rup_year' => 'Год',
            'status' => 'Статус',
            'create_ts' => 'Create Ts',
            'delete_ts' => 'Delete Ts',
            'lastopen_ts' => 'Lastopen Ts',
            'lastclose_ts' => 'Lastclose Ts',
            'create_userid' => 'Create Userid',
            'delete_userid' => 'Delete Userid',
            'lastopen_userid' => 'Lastopen Userid',
            'lastclose_userid' => 'Lastclose Userid',
            'captionRu' => 'Наименование плана',
            'captionKz' => 'Наименование плана',
            'lang' => 'Lang',
            'profile_code' => 'Профиль',
            'spec_code' => 'Специальность',
            'edu_form' => 'Форма обучения',
        ];
    }

    public function getStatusText(){
        $result = "";

        if ($this->status == RupRoots::STATUS_OPENED){
            $result = "Открыт для редактирования";
        }
        if ($this->status == RupRoots::STATUS_CLOSED){
            $result = "Закрыт для редактирования";
        }
        if ($this->status == RupRoots::STATUS_DELETED){
            $result = "Удален";
        }

        return $result;        
    }
}
