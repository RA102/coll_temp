<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use yii\web\Application;
use common\components\ActiveForm;

class CurrentInstitutionForm extends Model
{
    public $current_institution;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['current_institution'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'current_institution' => Yii::t('app', 'Текущий колледж'),
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
