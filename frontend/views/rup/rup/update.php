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
        'model' => $model,
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
            'content'=>'wait Please',
            'linkOptions'=>['data-url'=>Url::to(['/rup/rup/returnjson/']),'data-loading-class'=>'calsssss'],
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
    echo "<table border=\"1\" style='background-color: white; width: 70%; '>
   <tr>
    <th>Квалификация</th>
    <th>Срок</th>
    <th>Уровень</th>
   </tr>";


    foreach ($qualifications as $q){
        $id = $q['id'];
        $name = $q['qualification_name'];
        $time = $q['time_years']." года ".$q['time_months']." Месяцев";
        echo "

   <tr><td>{$name}</td><td>{$time}</td><td></td><td><button class='btn btn-danger delete_qual' id='{$id}'><h6>X</h6></button></td></tr>

        ";
    }

echo "  </table>";


    Modal::begin([
        'header' => '<h2>Добавить</h2>',
        'toggleButton' => ['label' => 'Добавить','class'=>'btn btn-success'],

    ]);

    echo $this->renderAjax('/rup/rup-qualifications/_form',['model'=> $qModel=new RupQualifications()]);

    Modal::end();
    ?>


    <script>
        $('.delete_qual').on('click',function () {

            $.ajax({
                type: 'GET',
                url: '/rup/rup-qualifications/delete-from-rup',
                data: {'id':this.id},
                success: function(data){
                    location.reload();
                }
            });

            // alert(this.id);
        });
        $('#submitQualification').on('click',function (e) {
            var rup_id=$('#ruproots-rup_id').val()
            e.preventDefault();
            $('#rupqualifications-rup_id').val(rup_id);
            $.ajax({
                type: 'POST',
                url: '/rup/rup-qualifications/create',
                data: $('#w3').serialize(),
                success: function(data){
                    location.reload();
                }
            });
            $('#w2').fadeToggle();
            $('#w2').css('display:none');
            $('.modal-backdrop').remove();
        });


        $('#w0').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/rup/rup/update'+'?id='+$('#ruproots-rup_id').val(),
                data: $('#w0').serialize(),
                success: function(data){
                    alert('Успешно обновлено, сейчас страница обновиться');
                    // location.reload();
                }
            });
        })
    </script>
</div>
</div>