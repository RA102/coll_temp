<?php

use common\helpers\InstitutionDisciplineHelper;
use common\models\organization\InstitutionDiscipline;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Планируемый объем нагрузки по практике, дипломному проектированию.';
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
                    'label'     => 'Название'
                ],
                [
                    'attribute' => 'group_id',
                    'label'     => 'Группа',
                    'value'     => function (\common\models\practice $model) {
                        return $model->group->caption_current;
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['practice-discipline-view', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
	</div>
</div>