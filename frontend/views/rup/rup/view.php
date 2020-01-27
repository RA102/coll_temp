<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */

$this->title = $model->rup_id;
$this->params['breadcrumbs'][] = ['label' => 'Rup Roots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="rup-roots-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rup_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rup_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'rup_id',
            'rup_year',
            'status',
            'create_ts',
            'delete_ts',
            'lastopen_ts',
            'lastclose_ts',
            'create_userid',
            'delete_userid',
            'lastopen_userid',
            'lastclose_userid',
            'captionRu',
            'captionKz',
            'lang',
            'profile_code',
            'spec_code',
            'edu_form',
        ],
    ]) ?>

</div>
