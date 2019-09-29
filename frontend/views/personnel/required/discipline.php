<?php

use common\helpers\InstitutionDisciplineHelper;
use common\models\organization\InstitutionDiscipline;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Планируемый объем нагрузки по дисциплинам ';
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

                [
                    'attribute' => 'caption_current',
                ],

                [
                    'attribute' => 'types',
                    'value' => function(InstitutionDiscipline $model) {
                        if ($model->types) {
                            return implode(', ', array_map(function ($item) {
                                return InstitutionDisciplineHelper::getTypeList()[$item];
                            }, $model->types));
                        }
                        return null;
                    }
                ],
                'create_ts',
                //'update_ts',
                //'delete_ts',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['required-discipline-view', 'discipline_id' => $model->id], [
                                    'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
	</div>
</div>