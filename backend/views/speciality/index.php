<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\handbook\SpecialitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $parent_id int */

$this->title = Yii::t('app', 'Specialities');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="speciality-index">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'caption_current',
                'code:ntext',
                'is_deleted:boolean',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {child}',
                    'buttons' => [
                        'child' => function($url, $model, $key) {
                            return Html::a(Html::tag('span','', ['class'=>'glyphicon glyphicon-th-list']), ['index', 'parent_id' => $model->id]);
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create', 'parent_id' => $parent_id], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>

<?= $this->render('_layout') ?>