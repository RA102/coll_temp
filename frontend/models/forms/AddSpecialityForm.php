<?php
namespace frontend\models\forms;

use yii\base\Model;
use Yii;
use yii\web\Application;
use common\components\ActiveForm;

/**
 * AddSpecialityForm form
 */
class AddSpecialityForm extends Model
{
    public $speciality_ids = [];

    public $hasSpecialityId = false;

    public $is_submitted = 0;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speciality_ids'], 'default', 'value' => null],
            [['speciality_ids', 'is_submitted'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'speciality_ids' => Yii::t('app', 'ID'),
        ];
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        if (Yii::$app instanceof Application && (
                Yii::$app->request->post(ActiveForm::$refreshParam)
                || Yii::$app->request->get(ActiveForm::$refreshParam)
            )
        ) {
            return false;
        }

        return parent::validate($attributeNames, $clearErrors);
    }
}
