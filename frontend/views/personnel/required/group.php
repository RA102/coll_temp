<?php

use common\models\RequiredDisciplines;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Планируемый объем нагрузки на группы по дисциплинам ';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Работа с инженерно-педагогическими кадрами'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
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

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['required-group-view', 'group_id' => $model->id], [
                                    'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
	</div>
</div>