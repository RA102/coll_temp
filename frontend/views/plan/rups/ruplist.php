<?php

use common\models\rups\RupRoot;
//use common\models\organization\Group;
use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Перечень РУП';

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Планирование учебного процесса'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <!-- <?= Html::a('Добавить', ['create-required'], ['class' => 'title-action btn btn-primary']) ?> -->
</div>

<div class="required-index skin-white">
	<div class="card-body">
		<?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'rup_year',
                    'value' => $model->rup_year,
                    //'label' => 'год'
                ],
                [
                    'attribute' => 'profile_code',
                    'value' => $model->profile_code,
                ],                
                [
                    'attribute' => 'spec_code',
                    'value' => $model->spec_code,
                ],                  
                [
                    'attribute' => 'captionRu',
                    'value' => $model->captionRu,
                    //'label' => 'название'
                ],
                [
                    'attribute' => 'status',
                    //'value' => $model->getStatusName(),
                    'value' => function ($model) {
                        return $model->getStatusName();
                    }
                ],

                [
                	'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                	'urlCreator' => function ($action, $model, $key, $index) {
                        if ($action === 'view') {
                            $url ='view-required-groups?teacher_course_id='.$model->rup_id;
                            return $url;
                        }
                        if ($action === 'update') {
                            $url ='update-required?teacher_course_id='.$model->rup_id;
                            return $url;
                        }
                        if ($action === 'delete') {
                            $url ='delete-required?teacher_course_id='.$model->rup_id;
                            return $url;
                        }
                    }
                ],
            ],
        ]); ?>
	</div>
</div>