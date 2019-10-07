<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить студентов';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
	<div class="card-body">

	    <?php $form = ActiveForm::begin(); ?>
	    	<?= $form->field($model, 'group')->hiddenInput(['value' => $group->id])->label(false) ?>
		    <?= $form->field($model, 'students')->widget(Select2::class, [
		        'data' => ArrayHelper::map($students, 'id', 'fullName'), /** @see Employee::getFullName() */ // TODO rework to ajax
		        'options' => ['placeholder' => 'Выберите студентов', 'class' => 'active-form-refresh-control'],
		        'theme' => 'default',
		        'pluginOptions' => [
		            'allowClear' => true,
		            'multiple' => true,
		        ],
		    ]) ?>

			<div class="form-group">
		        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
		    </div>

	    <?php ActiveForm::end(); ?>

	</div>
</div>