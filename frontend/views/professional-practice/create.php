<?php

$this->title = 'Добавить профессиональную практику';
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