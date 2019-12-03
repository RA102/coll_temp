<?php

use common\helpers\InstitutionDisciplineHelper;
use common\models\organization\InstitutionDiscipline;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Дисциплины');
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
                    'value' => function(InstitutionDiscipline $model) {
                        return $model->caption_current;
                    },
                ],

                [
                    'attribute' => 'types',
                    'value' => function(InstitutionDiscipline $model) {
                        if ($model->types) {
                            return implode(', ', array_map(function ($item) {
                                if (array_key_exists($item, InstitutionDisciplineHelper::getTypeList())) {
                                    return InstitutionDisciplineHelper::getTypeList()[$item];
                                }
                            }, $model->types));
                        }
                        return null;
                    },
                    //'filter' => \common\helpers\InstitutionDisciplineHelper::getTypeList(),
                ],
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
