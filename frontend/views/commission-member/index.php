<?php

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Commission members');
$this->params['breadcrumbs'][] = $this->title;

use yii\grid\GridView;
use yii\helpers\Html; ?>
<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create', 'id' => $employeeSearch->commission_id], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="group-index skin-white">
    <div class="card-body">
<?= GridView::widget([
    'dataProvider' => $employeeDataProvider,
    'filterModel' => $employeeSearch,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'firstname',
        'lastname',
        'middlename',
        'birth_date',
        'iin',
    ],
]); ?>
    </div>
</div>
