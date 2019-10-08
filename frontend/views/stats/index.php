<?php

use common\models\organization\Institution;

$this->title = 'Отчет 2-НК'
?>


<h1>Форма 2-НК</h1>

<div class="card-body skin-white">
	<div class="row">
		
	</div>
	<table class="table table-bordered table-condensed table-striped">
		<tr>
			<th rowspan="2">Код строки</th>
			<th rowspan="2">Наименование показателя</th>
			<th rowspan="2">Всего</th>
			<th colspan="3">В том числе на базе:</th>
		</tr>
		<tr>
			<th>основного среднего образования</th>
			<th>общего среднего образования</th>
			<th>технического и профессионального, полусреднего образования</th>
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