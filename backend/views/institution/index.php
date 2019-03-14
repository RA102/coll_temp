<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\InstitutionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Institutions');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginBlock('content') ?>
    <div class="institution-index">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'name',
                [
                    'attribute' => 'city_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->city->caption_current;
                    }
                ],
                [
                    'attribute' => 'educational_form_id',
                    'value' => function(\common\models\organization\Institution $model) {
                        return $model->educationalForm->caption_current;
                    }
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
<?php $this->endBlock() ?>

<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>

<?= $this->render('_layout') ?>