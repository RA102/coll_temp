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

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="institution-discipline-index">

        <p>
            <?= Html::a(Yii::t('app', 'Create Institution Discipline'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

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
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>