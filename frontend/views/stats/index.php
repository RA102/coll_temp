<?php

use common\models\organization\Institution;
use yii\helpers\Html;

$this->title = 'Отчеты';

$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Форма 2-НК</h1>


<div class="card-header">
        <ul class="nav nav-tabs">
            <li role="presentation">
                <?= Html::a('Совместители', ['pluralist'], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Совместители', ['pluralist'], []) ?>
            </li>
        </ul>
</div>
    
<div class="card-body skin-white">
	<div class="row">
		<a href="01">Отчёт №1</a>
	</div>
</div>