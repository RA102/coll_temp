<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\search\ReceptionGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Groups');
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a('Добавить', ['create', 'id' => $searchModel->commission_id], ['class' => 'title-action btn btn-primary']) ?>
</div>

<div class="reception-group-index skin-white">
    <div class="card-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'format' => 'html',
                'attribute' => 'caption_current',
                'value' => function (\common\models\ReceptionGroup $model) {
                    return Html::a($model->caption_current, ['view', 'id' => $model->id]);
                }
            ],
            [
                'format'    => 'html',
                'attribute' => 'language',
                'value'     => function (\common\models\ReceptionGroup $model) {
                    return $model->getLanguage();
                },
            ],
            [
                'format'    => 'html',
                'attribute' => 'speciality_id',
                'value'     => function (\common\models\ReceptionGroup $model) {
                    return $model->speciality->caption_current ?? null;
                },
            ],
            [
                'format'    => 'html',
                'attribute' => 'education_form',
                'value'     => function (\common\models\ReceptionGroup $model) {
                    return $model->getEducationPayForm() ?? null;
                },
            ],
//            'education_form',
            //'institution_id',
            //'budget_places',
            //'commercial_places',
            //'create_ts',
            //'update_ts',
            //'delete_ts',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
    </div>
</div>
