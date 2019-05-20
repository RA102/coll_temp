<?php

use common\models\reception\AdmissionProtocol;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this \yii\web\View */
/* @var $searchModel \frontend\search\AppealApplicationSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $form \frontend\models\forms\EntranceExamOrderForm */
/* @var $protocols \common\models\reception\AdmissionProtocol[] */

$this->title = Yii::t('app', 'Order of admission to entrance exams');
?>

<h1><?=$this->title?></h1>

<div class="group-index skin-white">
    <div class="card-header">
        <?=Yii::t('app', 'Form document')?>
    </div>

    <div class="card-body">
        <?php $activeForm = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-4">
                <?= $activeForm->field($form, 'date')->widget(DatePicker::class, [
                    'language' => 'ru',
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]); ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'number')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4">
                <?= $activeForm->field($form, 'protocol_id')->widget(Select2::classname(), [
                    'data' => \yii\helpers\ArrayHelper::map($protocols, 'id', function(AdmissionProtocol $model) {
                        return '№ '
                            . $model['number']
                            . ', '
                            . mb_strtolower(Yii::t('app', 'Date'), 'UTF-8')
                            . ' '
                            . date('d.m.Y', strtotime($model['completion_date']));
                    }),
                    'options' => ['placeholder' => ''],
                    'theme' => 'default',
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Form'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>