<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Person */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'status',
            'nickname',
            'firstname',
            'lastname',
            'middlename',
            'birth_date',
            'sex',
            'nationality_id',
            'iin',
            'is_pluralist',
            'birth_country_id',
            'birth_city_id',
            'birth_place',
            'language',
            'oid',
            'alledu_id',
            'alledu_server_id',
            'pupil_id',
            'owner_id',
            'server_id',
            'is_subscribed:boolean',
            'portal_uid',
            'photo',
            'type',
            'create_ts',
            'delete_ts',
            'import_ts',
            'person_type',
        ],
    ]) ?>

</div>
