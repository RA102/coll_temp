<?php

$this->title = 'Редактировать профессиональную практику';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Профессиональная практика'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
	<div class="card-body">
		<?= $this->render('_form', [
            'model' => $model,
            'types' => $types,
        ]) ?>
	</div>
</div>