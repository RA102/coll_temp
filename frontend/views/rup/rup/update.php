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
            'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=1'])]
        ],
        [
            'label'=>'<i class="fas fa-edit"></i> Детализация плана',
            'content'=>$content2,
            'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=2'])]
        ],
    ];
    // Ajax Tabs Above
    echo TabsX::widget([
        'items'=>$items,
        'position'=>TabsX::POS_ABOVE,
        'encodeLabels'=>false
    ]);
    echo "<table border=\"1\" style='background-color: white; width: 70%;float: left; '>
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
    echo "<input type='text' style='width:20%;float: right;'><br>";


    Modal::begin([
        'header' => '<h2>Добавить</h2>',
        'toggleButton' => ['label' => 'Добавить','class'=>'btn btn-success','style'=>['float'=>'left']],

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
        })
    </script>
</div>
