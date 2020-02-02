<?php

use frontend\models\rup\RupQualifications;
use kartik\tabs\TabsX;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */

$this->title = 'Обновить РУП: ' . $model->captionRu;
$this->params['breadcrumbs'][] = ['label' => 'Rup Roots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rup_id, 'url' => ['view', 'id' => $model->rup_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card-body skin-white">
<div class="rup-roots-update">

    <h1><?= Html::encode($this->title) ?></h1>
<!---->
<!--    --><?php //echo $this->render('_form', [
//        'model' => $model,
//    ]) ?>

    <?php
    $content = $this->renderAjax('_formUpdate', [
        'qualifications'=>$qualifications,
        'model' => $model,
    ]);

    $content2 =$this->renderAjax('/rup/rup-sub-block/index',[
//            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
    ]);


    $items = [
        [
            'label'=>'<i class="fas fa-info"></i> Основные данные',
            'content'=> $content,
            'active'=>true,
            'linkOptions'=>[]
        ],
        [
            'label'=>'<i class="fas fa-edit"></i> Детализация плана',
            'content'=>$content2,
//            'linkOptions'=>['data-url'=>Url::toRoute(['/rup/rup-subjects/index-tab/','rup_id'=>$model->rup_id,]),'data-loading-class'=>'calsssss'],
        ],
    ];
    // Ajax Tabs Above
    echo TabsX::widget([
        'items'=>$items,
        'position'=>TabsX::POS_ABOVE,
        'encodeLabels'=>false,
        'options' => [
                 'ajaxSettings' => [
                'type' => 'GET'
        ]
]

    ]);
?>


    <div id="editModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Изменить</h4>
                </div>
                <div id='editModalBody' class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $( document ).ready(function() {
            $.ajax({
                url: '/rup/rup-subjects/get-info',
                data:{'id':this.id},
                success: function() {
                    // alert(data);
                }
            });
        });

    </script>
</div>
</div>