    <?php

    use common\models\ProfessionalPractice;
    use yii\helpers\Html;
    use yii\grid\GridView;

    $this->title = 'Профессиональная практика';
    ?>

    <div style="position: relative;">
        <h1><?=$this->title?></h1>
        <?= Html::a('Добавить', ['create'], ['class' => 'title-action btn btn-primary']) ?>
    </div>

    <div class="optional-index skin-white">
    	<div class="card-body">
    		<?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'caption',
                        'value' => function (ProfessionalPractice $model) {
                            return $model->caption_current;
                        },
                        'label' => 'Название'
                    ],
                    [
                        'attribute' => 'type',
                        'value' => function (ProfessionalPractice $model) {
                            return $model->type();
                        },
                        'label' => 'Тип'
                    ],

                    [
                    	'class' => 'yii\grid\ActionColumn',
                    	'template' => '{update} {delete}',
                    	'urlCreator' => function ($action, $model, $key, $index) {
    		            if ($action === 'view') {
    		                $url ='view?id='.$model->id;
    		                return $url;
    		            }
    		            if ($action === 'update') {
    		                $url ='update?id='.$model->id;
    		                return $url;
    		            }
    		            if ($action === 'delete') {
    		                $url ='delete?id='.$model->id;
    		                return $url;
    		            }
    		          }
                    ],
                ],
            ]); ?>
    	</div>
    </div>