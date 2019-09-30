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

                'disciplineName',
                [
                    'format'    => 'html',
                    'attribute' => 'teacher_id',
                    'value'     => function (\common\models\TeacherCourse $model) {
                        return $model->person->fullName;
                    },
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['practice-discipline-view', 'teacher_course_id' => $model->id], [
                                    'title' => Yii::t('app', 'lead-view'),
                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
	</div>
</div>