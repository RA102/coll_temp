<?php

use common\helpers\DisciplineHelper;
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
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'discipline_id',
                    'value' => function (InstitutionDiscipline $model) {
                        return $model->discipline->caption; // TODO fix caption
                    }
                ],

                [
                    'attribute' => 'types',
                    'value' => function(InstitutionDiscipline $model) {
                        return implode(', ', array_map(function ($item) {
                            return DisciplineHelper::getTypeList()[$item];
                        }, $model->types));
                    }
                ],
                'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
