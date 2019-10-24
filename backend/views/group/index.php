<?php

use common\helpers\InstitutionHelper;
use common\helpers\PersonTypeHelper;
use common\models\organization\Institution;
use common\models\person\Person;
use common\models\person\PersonCredential;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PersonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Пользователи');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $this->beginBlock('content') ?>
    <div class="person-index" style="overflow: scroll">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'caption_current',
                [
                    'format'    => 'html',
                    'attribute' => 'language',
                    'value'     => function (\common\models\organization\Group $model) {
                        return $model->getLanguage();
                    },
                ],
                [
                    'format'    => 'html',
                    'attribute' => 'speciality_id',
                    'value'     => function (\common\models\organization\Group $model) {
                        return $model->speciality->getCaptionWithCode() ?? null;
                    },
                ],
                'class',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>

<?php $this->endBlock() ?>

<?php $this->beginBlock('tools') ?>
<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['create'], ['class' => 'btn btn-default']) ?>
<?php $this->endBlock() ?>

<?= $this->render('_layout') ?>