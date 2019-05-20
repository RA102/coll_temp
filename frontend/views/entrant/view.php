<?php

use common\helpers\PersonHelper;
use common\models\person\Entrant;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Entrant */

$this->title = $model->getFullName();
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entrants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div style="position: relative;">
    <h1 class="pull-left"><?=$this->title?></h1>
</div>
<div class="clearfix"></div>

<div class="card">
    <div class="card-body">
        <div class="entrant-view">

            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    'id',
//                    'status',
//                    'nickname',
                    'firstname',
                    'lastname',
                    'middlename',
                    'birth_date',
                    [
                        'attribute' => 'sex',
                        'value' => function(Entrant $model) {
                            return PersonHelper::getSexList()[$model->sex];
                        }
                    ],
                    [
                        'attribute' => 'nationality_id',
                        'value' => function(Entrant $model) {
                            return $model->nationality->name;
                        }
                    ],
                    'iin',
//                    'is_pluralist',
//                    'birth_country_id',
//                    'birth_city_id',
                    'birth_place',
//                    'language',
//                    'oid',
//                    'alledu_id',
//                    'alledu_server_id',
//                    'pupil_id',
//                    'owner_id',
//                    'server_id',
//                    'is_subscribed:boolean',
//                    'portal_uid',
//                    'photo'
                ],
            ]) ?>

        </div>
    </div>
</div>