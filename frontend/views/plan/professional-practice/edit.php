<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\reception\AppealApplication */
/* @var $form yii\widgets\ActiveForm */
/* @var $entrants \common\models\person\Entrant[] */
$practices = ArrayHelper::map($practices, 'id', 'caption_current');

$this->title = 'Назначить профессиональную практику';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Профессиональная практика'), 'url' => ['professional-practice']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card-body skin-white">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'practice_id')->widget(Select2::class, [
        'data' => $practices, // TODO rework to ajax
        'options' => ['placeholder' => 'Выберите практику', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ])->label('Практика') ?>

    <?= $form->field($model, 'group_id')->widget(Select2::class, [
        'data' => ArrayHelper::map($groups, 'id', 'caption_current'), /** @see Group::$caption_current */ // TODO rework to ajax
        'options' => ['placeholder' => 'Выберите группу', 'class' => 'active-form-refresh-control'],
        'theme' => 'default',
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]) ?>


    <?= $form->field($model, 'weeks[first]')->textInput()->label('Начальная неделя') ?>

    <?= $form->field($model, 'weeks[last]')->textInput()->label('Конечная неделя') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
