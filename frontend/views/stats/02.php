<?php

use common\models\organization\Institution;
use yii\helpers\Html;

$this->title = 'Отчет №2';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Отчеты'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Форма 2-НК</h1>

<div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation">
                <?= Html::a('1', ['01'], []) ?>
            </li>
            <li role="presentation" class="active">
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

<div class="card-body skin-white" style="overflow-x: scroll;">

	<div class="row">
		
	</div>
	<table class="table table-bordered table-condensed table-striped">
		<tr class="table-head">
			<th rowspan="3" class="v-middle">Код строки</th>
			<th rowspan="3" class="v-middle">Наименование квалификации</th>
			<th rowspan="3" class="v-middle">Код квалификации</th>
			<th colspan="2" style="text-align: center;">Принято обучающихся:</th>
			<th rowspan="3" class="v-middle">Численность обучающихся</th>
			<th colspan="8" style="text-align: center;">В том числе:</th>
			<th rowspan="3" class="v-middle">Выпущено обучившихся</th>
			<th colspan="8" style="text-align: center;">В том числе:</th>
		</tr>
		<tr class="table-head">
			<th rowspan="2">всего</th>
			<th rowspan="2">женского пола</th>
			<th colspan="2" style="text-align: center;">I курс</th>
			<th colspan="2" style="text-align: center;">II курс</th>
			<th colspan="2" style="text-align: center;">III курс</th>
			<th colspan="2" style="text-align: center;">Свыше III курса</th>
			<th colspan="2" style="text-align: center;">I курс</th>
			<th colspan="2" style="text-align: center;">II курс</th>
			<th colspan="2" style="text-align: center;">III курс</th>
			<th colspan="2" style="text-align: center;">Свыше III курса</th>
		</tr>
		<tr class="table-head">
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
			<th>Всего</th>
			<th>Женского пола</th>
		</tr>
		<tr class="info">
			<td>А</td>
			<td>Б</td>
			<td>В</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
			<td>4</td>
			<td>5</td>
			<td>6</td>
			<td>7</td>
			<td>8</td>
			<td>9</td>
			<td>10</td>
			<td>11</td>
			<td>12</td>
			<td>13</td>
			<td>14</td>
			<td>15</td>
			<td>16</td>
			<td>17</td>
			<td>18</td>
			<td>19</td>
			<td>20</td>
		</tr>
		<tr>
			<td>1</td>
			<td>Всего</td>
			<td></td>
			<td><?=count($entrants)?></td>
			<td><?=count($entrants_female)?></td>
			<td><?=count($institution->students)?></td>
		</tr>
		<?php $i = 2;?>
		<?php foreach($specialities as $speciality):?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$speciality->caption_current?></td>
				<td><?=$speciality->code?></td>
				<td><?=count($speciality->entrants)?></td>
				<td><?=count($speciality->entrantsFemale)?></td>
				<td><?=count($speciality->students)?></td>
				<td></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>