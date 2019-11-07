<?php

use common\helpers\InstitutionDisciplineHelper;
use common\models\organization\InstitutionDiscipline;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Institution Disciplines');
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
                    'attribute' => 'caption_current',
                    'value' => function(InstitutionDiscipline $model) {
                        return $model->caption_current;
                    },
                ],

                [
                    'attribute' => 'types',
                    'value' => function(InstitutionDiscipline $model) {
                        if ($model->types) {
                            return implode(', ', array_map(function ($item) {
                                return InstitutionDisciplineHelper::getTypeList()[$item];
                            }, $model->types));
                        }
                        return null;
                    }
                ],
                //'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
