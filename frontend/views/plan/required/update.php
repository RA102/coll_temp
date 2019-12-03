<?php

$this->title = 'Редактировать обязательную дисциплину';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
	<div class="card-body">
		<?= $this->render('_form', [
            'model' => $model,
            'institutionDisciplines' => $institutionDisciplines,
            'groups' => $groups,
            'teachers' => $teachers,
        ]) ?>
	</div>
</div>