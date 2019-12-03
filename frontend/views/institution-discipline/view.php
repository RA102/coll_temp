<?php

use common\helpers\InstitutionDisciplineHelper;
use common\models\organization\InstitutionDiscipline;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\organization\InstitutionDiscipline */

$this->title = $model->caption_current;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Institution Disciplines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $this->beginBlock('content') ?>
    <div class="institution-discipline-view">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'caption_current',
                ],
                /*[
                    'attribute' => 'types',
                    'value' => function(InstitutionDiscipline $model) {
                        if ($model->types) {
                            return implode(', ', array_map(function ($item) {
                                return InstitutionDisciplineHelper::getTypeList()[$item];
                            }, $model->types));
                        }
                        return null;
                    }
                ],*/
                //'create_ts',
                //'update_ts',
                //'delete_ts',
            ],
        ]) ?>

        <br>

        <h4>Преподаватели</h4>
        <?= \yii\grid\GridView::widget([
            'summary'      => false,
            'showHeader'   => false,
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'models' => $model->getTeachers()
            ]),
            'columns'      => [
                'fullName'
            ]
        ]) ?>

    </div>
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>