<?php

use common\helpers\InstitutionDepartmentHelper;
use common\models\organization\InstitutionDepartment;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Кафедры');
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= $this->title ?></h1>
    <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="group-index skin-white">

    <div class="card-body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'caption',
                    'value' => function(InstitutionDepartment $model) {
                        return $model->caption_current;
                    },
                ],
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class'    => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',],
            ],
        ]); ?>
    </div>
</div>
