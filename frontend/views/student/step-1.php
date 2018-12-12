<?php

use common\models\Nationality;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\person\Student */

$this->title = Yii::t('app', 'Update Student: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<?php $this->beginBlock('content') ?>
    <div class="student-update">

        <div class="student-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'middlename')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'birth_date')->textInput() ?>

            <?= $form->field($model, 'sex')->textInput() ?>

            <?= $form->field($model, 'nationality_id')->dropDownList(\yii\helpers\ArrayHelper::map(Nationality::find()->all(), 'id', 'name')) ?>

            <?= $form->field($model, 'iin')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'birth_place')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>