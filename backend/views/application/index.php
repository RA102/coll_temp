<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\search\InstitutionApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cities [] */

$this->title = Yii::t('app', 'Institution Applications');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="institution-application-index"  style="overflow: scroll">

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
                    'filter' => $cities,
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->city->caption_current;
                    }
                ],
                'iin',
                'email:email',
                'phone',
                [
                    'attribute' => 'status',
                    'filter' => \common\helpers\InstitutionApplicationHelper::getStatusList(),
                    'value' => function(\common\models\organization\InstitutionApplication $model) {
                        return $model->getStatus();
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