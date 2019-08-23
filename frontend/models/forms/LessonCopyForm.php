<?php

namespace frontend\models\forms;

use common\models\Lesson;
use common\models\organization\Group;
use Yii;
use yii\base\Model;

class LessonCopyForm extends Model
{
    public function formName()
    {
        return '';
    }

    public $id;
    public $weeks;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weeks'], 'required'],
            [['weeks'], 'each', 'rule' => ['integer']],
            [['id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'weeks' => Yii::t('app', 'Weeks'),
        ];
    }

    public function apply(Lesson $lesson)
    {
        $lesson->weeks = $this->weeks;
        
        return $lesson;
    }
}
