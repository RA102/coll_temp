<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\DisciplineSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disciplines';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="discipline-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Create Discipline', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'caption',
                'slug',
                'status',
                'create_ts',
                //'update_ts',
                //'delete_ts',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
<?php $this->endBlock(); ?>
<?= $this->render('_layout') ?>