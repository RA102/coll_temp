<?php
namespace frontend\models\forms;

use yii\base\Model;
use Yii;
use yii\web\Application;
use common\components\ActiveForm;

/**
 * GroupAllocationForm form
 */
class GroupAllocationForm extends Model
{
    public $class;

    public $group_id;

    public function formName()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class', 'group_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'class' => Yii::t('app', 'Class'),
            'group_id' => Yii::t('app', 'Group'),
        ];
    }
}
