<?php

use frontend\models\rup\RupQualifications;
use kartik\tabs\TabsX;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\rup\RupRoots */

$this->title = 'РУП: ' . $model->captionRu;
$this->params['breadcrumbs'][] = ['label' => 'РУПы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->captionRu, 'url' => ['view', 'id' => $model->rup_id]];
$this->params['breadcrumbs'][] = 'Просмотр';
?>
<div class="card-body skin-white">
<div class="rup-roots-update">

    <h1><?= Html::encode($this->title) ?></h1>
<!---->
<!--    --><?php //echo $this->render('_form', [
//        'model' => $model,
//    ]) ?>

    <?php
    $content = $this->renderAjax('_formView', [
        'qualifications'=>$qualifications,
        'model' => $model,
    ]);

    $content2 =$this->renderAjax('/rup/rup-module/index-view',[
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
                    <input type="submit" class="btn btn-primary" id="sendQual" value="Сохранить изменения"></input>
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

        $('#sendQual').on('click',function () {
            var id = $('#editQualID').val();
            var code = $('#editQualQualCode').val();
            var name = $('#editQualQual').val();
            var year = $('#editQualYear').val();
            var month = $('#editQualMonth').val();
            var level = $('#editQualLevel').val();
            $.ajax({
                type: 'POST',
                url: '/rup/rup-qualifications/update-qual?id='+id,
                data: {'name':name,'code':code,'year':year,'month':month,'level':level},
                success: function(data){
                    location.reload();
                }
            });
        });

    </script>
    <script>
        $('#rup_save').on('click',function (e) {
            e.preventDefault();
            $('#modal').modal();
            $.ajax({
                type: 'POST',
                url: '/rup/rup/update'+'?id='+$('#ruproots-rup_id').val(),
                data: $('#w0').serialize(),
                success: function(data){
                    alert('Успешно обновлено, сейчас страница обновиться');
                    var url= "/rup/rup/update?id="+$('#ruproots-rup_id').val()+"&active=1";
                    window.location = url;
                }
            });
        });
        $('#rupEditOpen').on('click',function (e) {
            e.preventDefault();
            if (confirm('Вы действительно хотите открыть план для редактирования??')) {
                $('#ruproots-status').val('1');
                $('#w0 input[type="text"]').prop("disabled", false);
                $('#w0 select').prop("disabled", false);
                $('#rup_save').show();
                $('#rup_save').click();
            } else {
            }

        });

    </script>
</div>
    <style>
        body {
            padding-right: 0 !important;
        }
    </style>
</div>