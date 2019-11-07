<?php

use common\models\organization\Institution;
use yii\helpers\Html;

$this->title = 'Отчет №1';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Отчеты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<h1>Форма 2-НК</h1>


<div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <?= Html::a('1', ['01'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('2', ['02'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('3', ['03'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('4', ['04'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('5', ['05'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('6', ['06'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('7', ['07'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('8', ['08'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('9', ['09'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('10', ['10'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('11', ['11'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('12', ['12'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('13', ['13'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('14', ['14'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('15', ['15'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('16', ['16'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('17', ['17'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('18', ['18'], []) ?>
            </li>
        </ul>
</div>

<div class="card-body skin-white">

	<div class="row">
		
	</div>
	<table class="table table-bordered table-condensed table-striped">
		<tr>
			<th rowspan="2" class="table-head v-middle">Код строки</th>
			<th rowspan="2" class="table-head v-middle">Наименование показателя</th>
			<th rowspan="2" class="table-head v-middle">Всего</th>
			<th colspan="3" class="table-head h-center">В том числе на базе:</th>
		</tr>
		<tr>
			<th class="table-head h-center">основного среднего образования</th>
			<th class="table-head h-center">общего среднего образования</th>
			<th class="table-head h-center">технического и профессионального, полусреднего образования</th>
		</tr>
		<tr>
			<td>А</td>
			<td>Б</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
		</tr>
		<tr>
			<td>1</td>
			<td>Численность обучающихся на начало учебного года</td>
			<td><?=count($total)?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td>в том числе</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>1.1</td>
			<td>мужского пола</td>
			<td><?=count($total_male)?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>1.2</td>
			<td>женского пола</td>
			<td><?=count($total_female)?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>2</td>
			<td>Принято</td>
			<td><?=$entrants?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>		
		<tr>
			<td></td>
			<td>в том числе</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>2.1</td>
			<td>мужского пола</td>
			<td><?=$entrants_male?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>2.2</td>
			<td>женского пола</td>
			<td><?=$entrants_female?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>3</td>
			<td>Прибыло в течении предыдущего учебного года</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>		
		<tr>
			<td></td>
			<td>в том числе</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>3.1</td>
			<td>мужского пола</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>3.2</td>
			<td>женского пола</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>4</td>
			<td>Выбыло в течении предыдущего учебного года</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>		
		<tr>
			<td></td>
			<td>в том числе</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>4.1</td>
			<td>мужского пола</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>4.2</td>
			<td>женского пола</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>5</td>
			<td>Выпущено обучившихся</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>		
		<tr>
			<td></td>
			<td>в том числе</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>5.1</td>
			<td>мужского пола</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>5.2</td>
			<td>женского пола</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>6</td>
			<td>Ожидаемый выпуск</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
	</table>
</div>