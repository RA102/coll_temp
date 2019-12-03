<?php

$this->title = 'Редактировать практику';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Практика'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
	<div class="card-body">
		<?= $this->render('_form', [
            'model' => $model,
        ]) ?>
	</div>
</div>