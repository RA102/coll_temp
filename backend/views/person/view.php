<?php

use common\models\person\Person;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Person */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php $this->beginBlock('content') ?>
    <div class="person-view">

        <p>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Назад'), ['index'], ['class' => 'btn btn-default']) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'iin',
                [
                    'attribute' => 'status',
                    'value' => function (Person $model) {
                        $statuses = \common\helpers\PersonHelper::getStatusList();
                        return $statuses[$model->status] ?? 'unknown';
                    }
                ],
                'nickname',
                'firstname',
                'lastname',
                'middlename',
                'birth_date',
                'sex',
                'nationality_id',
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
<?php $this->endBlock() ?>
<?= $this->render('_layout') ?>

