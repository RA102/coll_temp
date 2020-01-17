<?php

namespace common\models\rups;

use common\helpers\SchemeHelper;
use Yii;

/**
 * This is the model class for table "teacher_course".
 *
 * @property int $rup_id
 * @property int $rup_year
 * @property int $teacher_id
 * @property string $type
 * @property string $create_ts
 * @property string $update_ts
 * @property string $delete_ts
 * @property int $status
 *
 */
class RupRoot extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return SchemeHelper::PUBLIC . 'rup_roots';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rup_year'], 'required'],
            // [['course_id', 'teacher_id'], 'default', 'value' => null],
            [['rup_year', 'status', 'edu_form'], 'integer'],
            [['captionRu', 'captionKz'], 'string', 'max' => 255],
            [['profile_code', 'spec_code'], 'string', 'max' => 12],
            [['lang'], 'string', 'max' => 6],
            // [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::class, 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            //'id' => Yii::t('app', 'ID'),
            'rup_id' => 'ИД',
            'rup_year' => 'Год',
            'status' => 'Статус',
            'create_ts' => 'Дата создания',
            'delete_ts' => 'Дата удаления',
            'lastopen_ts' => 'Дата открытия',
            'lastclose_ts' => 'Дата закрытия',

            'create_userid' => 'Польз., создал',
            'delete_userid' => 'Польз., удалил',
            'lastopen_userid' => 'Польз., открыл',
            'lastclose_userid' => 'Польз., закрыл',

            'captionRu' => 'Наименование',
            'captionKz' => 'Наименование',
            'lang' => 'Язык',
            'profile_code' => 'Профиль, код',
            'spec_code' => 'Специальность, код',
            'edu_form' => 'Форма обучения',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function statusList()
    {
        $list = [
            '0' => 'Новый',
            '1' => 'Удален',
            '2' => 'Открыт',
            '4' => 'Закрыт',
        ];

        return $list;
    }
    public function statusName($status)
    {
        $list = $this->statusList();

        return $list[$status];
    }

    public function getStatus($status)
    {
        if ($status !== null) {
            $list = $this->statusList();
            return $list[$status];
        }
    }

    public function getStatusName()
    {
        $list = $this->statusList();
        if (array_key_exists($this->status, $list)) {
            return $list[$this->status];
        }
    }

    public function eduFormList()
    {
        $list = [
            '0' => 'Очная',
            '1' => 'Заочная',
        ];

        return $list;
    }
    public function eduFormName($edu_form)
    {
        $list = $this->eduFormList();

        return $list[$edu_form];
    }

    public function getEduForm($edu_form)
    {
        if ($edu_form !== null) {
            $list = $this->eduFormList();
            return $list[$edu_form];
        }
    }

    public function getEduFormName()
    {
        $list = $this->eduFormList();
        if (array_key_exists($this->edu_form, $list)) {
            return $list[$this->edu_form];
        }
    }


  
}
