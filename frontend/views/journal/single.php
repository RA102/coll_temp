<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Журнал';
?>

<div class="card">
	<div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation">
                <?= Html::a('Теоретическое обучение', ['pluralist'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Курсовые проекты, лабораторно-практические и графические работы', ['pluralist'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Контрольные работы', ['pluralist'], []) ?>
            </li>
        </ul>
    </div>
	<div class="card-body">
		<table class="table table-bordered table-striped">
			<tr>
				<th>№</th>
				<th>ФИО</th>
				<th>Дата</th>
			</tr>
			<?php foreach ($group->students as $student):?>
				<tr>
					<td></td>
					<td><?=$student->getFullname()?></td>
					<td></td>
				</tr>
			<?php endforeach;?>
		</table>
	</div>
</div>