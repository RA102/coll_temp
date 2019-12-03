<?php

$this->title = 'Планирование практики ' . $model->practice->caption_current;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Практика'), 'url' => ['practice/index']];
$this->params['breadcrumbs'][] = ['label' => $model->practice->caption_current, 'url' => ['practice/view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
	<div class="card-body">
		<?= $this->render('_form', [
            'model' => $model,
            'practices' => $practices,
            'groups' => $groups,
            'teachers' => $teachers,
        ]) ?>
	</div>
</div>