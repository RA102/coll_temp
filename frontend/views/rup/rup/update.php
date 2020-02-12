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
$this->params['breadcrumbs'][] = ['label' => 'РУПы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->captionRu, 'url' => ['view', 'id' => $model->rup_id]];
$this->params['breadcrumbs'][] = 'Изменить';
if($active==1){
    $isActive1=true;
    $isActive2=false;
}
else{
    $isActive1=false;
    $isActive2=true;
}
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
    $content2 =$this->renderAjax('/rup/rup-block/index',[
            'searchModel'=>$searchModelBlock,
            'dataProvider'=>$dataProviderBlock,
            'rup_id'=>$model->rup_id,
        ]);
    $content2 =$content2.$this->renderAjax('/rup/rup-module/index',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
        'rup_id'=>$model->rup_id,
    ]);



    $items = [
        [
            'label'=>'<i class="fas fa-info"></i> Основные данные',
            'content'=> $content,
            'active'=>$isActive1,
            'linkOptions'=>[]
        ],
        [
            'label'=>'<i class="fas fa-edit"></i> Детализация плана',
            'content'=>$content2,
            'active'=>$isActive2,
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

<!--Mini edit window        -->
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
<!--    <button data-toggle="modal" data-target="#editModalModule"></button>-->
<!---Big edit window-->
    <div id="editModalModule" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Изменить</h4>
                </div>
                <div id='editModalBody' class="modal-body">
                    <form id="addQualification" action="\rup\rup-subjects\update">
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Модуль/Дисциплина:</div>
                            <div class="col-2"><input class="form-control" id="editModalModuleModuleIndex" type="text" placeholder="индекс"></div>
                            <div class="col-7"><input class="form-control" id="editModalModuleModule" type="text"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-3">Входит в модуль:</div>
                            <div class="col-9"><input class="form-control" id="editModalModuleInModule" type="text" disabled></div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Форма контроля:</div>
                            <div class="col-3" >Экзамен: <input class="form-control" id="editModalModuleFormControl1" type="number"></div>
                            <div class="col-3" >Зачет: <input class="form-control"  id="editModalModuleFormControl2" type="number"></div>
                            <div class="col-3" >Контрольная: <input class="form-control" id="editModalModuleFormControl3" type="number"></div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Часов для распределения:</div>
                            <div class="col-3" style="font-weight:bold">Всего: <input class="form-control" id="editModalModuleAllTime" type="number"></div>
                            <div class="col-3"> </div>
                            <div class="col-3" style="font-weight:bold">Не распределено: <input class="form-control" id="editModalModuleAllTimeNeraspred" type="text" disabled="true"></div>
                        </div>
                        
                        <br>
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Объем учебного времени:</div>
                            <div class="col-3" >Теоретическое: <input class="form-control" id="editModalModuleAllTimeTheory" type="number"></div>
                            <div class="col-3" >Лаб.-практическое: <input  class="form-control" id="editModalModuleAllTimeLab" type="number"></div>
                            <div class="col-3" >Производственное: <input class="form-control" id="editModalModuleAllTimeProd" type="number"></div>
                        </div>

                        <div class="row">
                            <div class="col-12" style="font-weight:bold">Время по семестрам:</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">1 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime1" type="number"></div>
                            
                            <div class="col-1">2 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime2" type="number"></div>
                        </div>               
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">3 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime3" type="number"></div>
                            
                            <div class="col-1">4 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime4" type="number"></div>
                        </div>               
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">5 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime5" type="number"></div>
                            
                            <div class="col-1">6 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime6" type="number"></div>
                        </div>               
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">7 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime7" type="number"></div>
                            
                            <div class="col-1">8 сем:</div>
                            <div class="col-2"><input class="form-control"  id="editModalModuleTime8" type="number"></div>
                        </div>               
                        
                        <br>


                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-primary" id="sendModule" value="Сохранить изменения"></input>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
<!--END OF BIG EDIT WINDOW-->



<!--    START OF BIG ADD QUALIFICATION WINDOW-->

    <!--    <button data-toggle="modal" data-target="#editModalModule"></button>-->
    <!---Big edit window-->
    <div id="addModalModule" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавить</h4>
                </div>
                <div id='addQualModalBody' class="modal-body">
                    <form id="addQualification" >
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Модуль/Дисциплина:</div>
                            <div class="col-2"><input class="form-control" id="addQualModalModuleModuleIndex" type="text" placeholder="индекс"></div>
                            <div class="col-7"><input class="form-control" id="addQualModalModuleModule" type="text"></div>
                        </div>

                        <div class="row">
                            <div class="col-3">Входит в модуль:</div>
                            <div class="col-9"><input class="form-control" id="addQualModalModuleInModule" type="text" disabled></div>
                        </div>
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Форма контроля:</div>
                            <div class="col-3" >Экзамен: <input class="form-control" id="addQualModalModuleFormControl1" type="number"></div>
                            <div class="col-3" >Зачет: <input class="form-control"  id="addQualModalModuleFormControl2" type="number"></div>
                            <div class="col-3" >Контрольная: <input class="form-control" id="addQualModalModuleFormControl3" type="number"></div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Часов для распределения:</div>
                            <div class="col-3" style="font-weight:bold">Всего: <input class="form-control" id="addQualModalModuleAllTime" type="number"></div>
                            <div class="col-3"> </div>
                            <div class="col-3" style="font-weight:bold">Не распределено: <input class="form-control" id="addQualModalModuleAllTimeNeraspred" type="text" disabled="true"></div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-3" style="font-weight:bold">Объем учебного времени:</div>
                            <div class="col-3" >Теоретическое: <input class="form-control" id="addQualModalModuleAllTimeTheory" type="number"></div>
                            <div class="col-3" >Лаб.-практическое: <input  class="form-control" id="addQualModalModuleAllTimeLab" type="number"></div>
                            <div class="col-3" >Производственное: <input class="form-control" id="addQualModalModuleAllTimeProd" type="number"></div>
                        </div>

                        <div class="row">
                            <div class="col-12" style="font-weight:bold">Время по семестрам:</div>
                        </div>

                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">1 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime1" type="number"></div>

                            <div class="col-1">2 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime2" type="number"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">3 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime3" type="number"></div>

                            <div class="col-1">4 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime4" type="number"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">5 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime5" type="number"></div>

                            <div class="col-1">6 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime6" type="number"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">7 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime7" type="number"></div>

                            <div class="col-1">8 сем:</div>
                            <div class="col-2"><input class="form-control"  id="addQualModalModuleTime8" type="number"></div>
                        </div>

                        <br>


                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <input type="submit" class="btn btn-primary" id="addQualModule" value="Добавить"></input>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

<!--    END OF BIG UPDATE WINDOW-->


    <script>
        //getParams in GET param;
        var queryDict = {}
        location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]});
        console.log(queryDict);
        if(queryDict.block_id==null){
            $('.rup-sub-block-index').hide();
        }
        else{
            $('.rup-sub-block-index').show();
        }
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


        //ИЗМЕНИТЬ ИЛИ ДОБАВИТЬ МОДУЛЬ
        $('#sendModule').on('click',function () {
            alert('123');
            $.ajax({
                type: 'POST',
                url: '/rup/rup-subjects/update-qual?id='+id,
                data: {'name':name,'code':code,'year':year,'month':month,'level':level},
                success: function(data){
                    location.reload();
                }
            });
        });

        $('#addQualModule').on('click',function (e) {
            e.preventDefault();
            alert('123');
            console.log($('#addQualModalModuleModuleIndex').val())
                // $.ajax({
                //     type: 'POST',
                //     url: '/rup/rup-subjects/update-qual?id='+id,
                //     data: {$('#addQualification').serialize()},
                // success: function(data){
                //     alert('321');
                // },
        //     })
        });
    </script>
</div>
    <style>
        body {
            padding-right: 0 !important;
        }
        b{
            padding: 10px;
        }
    </style>
</div>