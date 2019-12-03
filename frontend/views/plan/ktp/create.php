<?php

$this->title = 'КТП';
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="card">
	<div class="card-body">
		<?= $this->render('_form', [
            'model' => $model,
            'required' => $required,
            'groups' => $groups,
            'institutionDisciplines' => $institutionDisciplines,
            'teachers' => $teachers,
        ]) ?>
	</div>
</div>