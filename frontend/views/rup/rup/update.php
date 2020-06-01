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
    <!--Mini edit window  BLOCK       -->
    <div id="editModalBlock" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Изменить</h4>
                </div>
                <div id='editModalBodyBlock' class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <input type="submit" class="btn btn-primary" id="sendQualBlock" value="Сохранить изменения"></input>
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
                            <div class="col-3" >Экзамен: <input class="form-control" id="editModalModuleFormControl1" type="" maxlength="6"></div>
                            <div class="col-3" >Зачет: <input class="form-control"  id="editModalModuleFormControl2" type="" maxlength="6"></div>
                            <div class="col-3" >Контрольная: <input class="form-control" id="editModalModuleFormControl3" type="" maxlength="6"></div>
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
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime1" type="number"></div>

                            <div class="col-1">2 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime2" type="number"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">3 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime3" type="number"></div>

                            <div class="col-1">4 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime4" type="number"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">5 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime5" type="number"></div>

                            <div class="col-1">6 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime6" type="number"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">7 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime7" type="number"></div>

                            <div class="col-1">8 сем:</div>
                            <div class="col-2"><input class="form-control semEditEdit"  id="editModalModuleTime8" type="number"></div>
                        </div>

                        <br>


                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <input type="text" class="hidden" id="editModalID">
                        <input type="submit" class="btn btn-primary" id="sendModule" value="Сохранить изменения" disabled="true"></input>
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
                            <div class="col-3" >Экзамен: <input class="form-control" id="addQualModalModuleFormControl1" type="" maxlength="6"></div>
                            <div class="col-3" >Зачет: <input class="form-control"  id="addQualModalModuleFormControl2" type="" maxlength="6"></div>
                            <div class="col-3" >Контрольная: <input class="form-control" id="addQualModalModuleFormControl3" type="" maxlength="6"></div>
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
                            <div class="col-3" >Теоретическое: <input class="form-control allTimePart" id="addQualModalModuleAllTimeTheory" type="number" value="0"></div>
                            <div class="col-3" >Лаб.-практическое: <input  class="form-control allTimePart" id="addQualModalModuleAllTimeLab" type="number" value="0"></div>
                            <div class="col-3" >Производственное: <input class="form-control allTimePart" id="addQualModalModuleAllTimeProd" type="number" value="0"></div>
                        </div>

                        <div class="row">
                            <div class="col-12" style="font-weight:bold">Время по семестрам:</div>
                        </div>

                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">1 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime1" type="number" value="0"></div>

                            <div class="col-1">2 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime2" type="number" value="0"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">3 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime3" type="number" value="0"></div>

                            <div class="col-1">4 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime4" type="number" value="0"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">5 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime5" type="number" value="0"></div>

                            <div class="col-1">6 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime6" type="number" value="0"></div>
                        </div>
                        <div class="row">
                            <div class="col-3"> </div>
                            <div class="col-1">7 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime7" type="number" value="0"></div>

                            <div class="col-1">8 сем:</div>
                            <div class="col-2"><input class="form-control semEdit"  id="addQualModalModuleTime8" type="number" value="0"></div>
                        </div>

                        <br>


                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <input type="text" class="hidden" id="moduleAppendId">
                        <input type="submit" class="btn btn-primary" id="addQualModule" value="Добавить" disabled="true"></input>
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
        // console.log(queryDict);
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
        $('#sendModule').on('click',function (e) {
            e.preventDefault();
            var id =$('#editModalID').val();
            var code = $('#editModalModuleModuleIndex').val();
            var name = $('#editModalModuleModule').val();
            var rup_id = $('#ruproots-rup_id').val();
            var one_sem_time = $('#editModalModuleTime1').val();
            var two_sem_time = $('#editModalModuleTime2').val();
            var three_sem_time = $('#editModalModuleTime3').val();
            var four_sem_time = $('#editModalModuleTime4').val();
            var five_sem_time = $('#editModalModuleTime5').val();
            var six_sem_time = $('#editModalModuleTime6').val();
            var seven_sem_time = $('#editModalModuleTime7').val();
            var eight_sem_time = $('#editModalModuleTime8').val();
            var production_practice_time = $('#editModalModuleAllTimeProd').val();
            var lab_time = $('#editModalModuleAllTimeLab').val();
            var teory_time=$('#editModalModuleAllTimeTheory').val();
            var time=$('#editModalModuleAllTime').val();
            var offset=$('#editModalModuleFormControl2').val();
            var control_work=$('#editModalModuleFormControl3').val();
            var exam=$('#editModalModuleFormControl1').val();
            var id_block=queryDict.block_id;
            var id_sub_block=$('#moduleAppendId').val();
            if(checkFormForEdit()){
                $.ajax({
                    type: 'GET',
                    url: '/rup/rup-subjects/update-subjectt?id='+id,
                    data: {'code':code,'name':name,'rup_id':rup_id,'one_sem_time':one_sem_time,
                        'two_sem_time':two_sem_time,'three_sem_time':three_sem_time,'four_sem_time':four_sem_time,
                        'five_sem_time':five_sem_time,'six_sem_time':six_sem_time,'seven_sem_time':seven_sem_time,
                        'eight_sem_time':eight_sem_time,'production_practice_time':production_practice_time,
                        'lab_time':lab_time,'teory_time':teory_time,'time':time,'offset':offset,'control_work':control_work,
                        'exam':exam,'id_block':id_block,'id_sub_block':id_sub_block},
                    success: function(data){
                        location.reload();
                    }
                });
            };
        });

        $('#addQualModule').on('click',function (e) {
            e.preventDefault();
            var code = $('#addQualModalModuleModuleIndex').val();
            var name = $('#addQualModalModuleModule').val();
            var rup_id = $('#ruproots-rup_id').val();
            var one_sem_time = $('#addQualModalModuleTime1').val();
            var two_sem_time = $('#addQualModalModuleTime2').val();
            var three_sem_time = $('#addQualModalModuleTime3').val();
            var four_sem_time = $('#addQualModalModuleTime4').val();
            var five_sem_time = $('#addQualModalModuleTime5').val();
            var six_sem_time = $('#addQualModalModuleTime6').val();
            var seven_sem_time = $('#addQualModalModuleTime7').val();
            var eight_sem_time = $('#addQualModalModuleTime8').val();
            var production_practice_time = $('#addQualModalModuleAllTimeProd').val();
            var lab_time = $('#addQualModalModuleAllTimeLab').val();
            var teory_time=$('#addQualModalModuleAllTimeTheory').val();
            var time=$('#addQualModalModuleAllTime').val();
            var offset=$('#addQualModalModuleFormControl2').val();
            var control_work=$('#addQualModalModuleFormControl3').val();
            var exam=$('#addQualModalModuleFormControl1').val();
            var id_block=queryDict.block_id;
            var id_sub_block=$('#moduleAppendId').val();
           if(checkFormForAdd()){
               $.ajax({
                   type: 'POST',
                   url: '/rup/rup-subjects/create-ajax',
                   data: {'code':code,'name':name,'rup_id':rup_id,'one_sem_time':one_sem_time,
                   'two_sem_time':two_sem_time,'three_sem_time':three_sem_time,'four_sem_time':four_sem_time,
                   'five_sem_time':five_sem_time,'six_sem_time':six_sem_time,'seven_sem_time':seven_sem_time,
                   'eight_sem_time':eight_sem_time,'production_practice_time':production_practice_time,
                   'lab_time':lab_time,'teory_time':teory_time,'time':time,'offset':offset,'control_work':control_work,
                   'exam':exam,'id_block':id_block,'id_sub_block':id_sub_block},
                   success: function(data){
                       location.reload();
                   }
               });
           };
        });

        $('.updateModuleButton').on('click',function () {
            // console.log($(this).attr('idd'));
            alert('123');
           // $('#editModalBody').data('subject_id',$(this).attr('idd'));
        });


        $( '#addModalModule' ).on('shown.bs.modal', function(event){
            document.getElementById("addQualification").reset();
            var button = $(event.relatedTarget);
            var ModalModuleId=button.attr('moduleid');


            $.ajax({
                url: "/rup/rup-module/getmoduleinfo?id="+ModalModuleId,
                context: document.body,
                success: function(data){
                    // console.log(ModalModuleId);
                    $('#moduleAppendId').val(parseInt(ModalModuleId));
                    $( ".semEdit" ).prop( "disabled", true );
                    $( ".allTimePart" ).prop( "disabled", true );
                    $('#addQualModalModuleInModule').val(data.name);
                    $('#addQualModalModuleTime1').val(0);
                    $('#addQualModalModuleTime2').val(0);
                    $('#addQualModalModuleTime3').val(0);
                    $('#addQualModalModuleTime4').val(0);
                    $('#addQualModalModuleTime5').val(0);
                    $('#addQualModalModuleTime6').val(0);
                    $('#addQualModalModuleTime7').val(0);
                    $('#addQualModalModuleTime8').val(0);
                    $('#addQualModalModuleAllTime').val(0);
                    $('#addQualModalModuleAllTimeTheory').val(0);
                    $('#addQualModalModuleAllTimeLab').val(0);
                    $('#addQualModalModuleAllTimeProd').val(0);
                    $('#addQualModalModuleFormControl1').val(0);
                    $('#addQualModalModuleFormControl2').val(0);
                    $('#addQualModalModuleFormControl3').val(0);
                    $('#addQualModalModuleModule').val('');
                    $('#addQualModalModuleModuleIndex').val('');
                }
            });

        });

        //EDIT BLOCK'////////////////////////////////////////////////////////////
        $('#editModalModuleAllTimeTheory').on('change',function () {
            var editModalModuleAllTimeTheory = parseInt($('#editModalModuleAllTimeTheory').val());
            var editModalModuleAllTimeLab=parseInt($('#editModalModuleAllTimeLab').val());
            var editModalModuleAllTimeProd=parseInt($('#editModalModuleAllTimeProd').val());
            var AllTime=$('#editModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(editModalModuleAllTimeTheory+editModalModuleAllTimeLab+editModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#editModalModuleTime1" ).prop( "disabled", true );
                $( "#editModalModuleTime2" ).prop( "disabled", true );
                $( "#editModalModuleTime3" ).prop( "disabled", true );
                $( "#editModalModuleTime4" ).prop( "disabled", true );
                $( "#editModalModuleTime5" ).prop( "disabled", true );
                $( "#editModalModuleTime6" ).prop( "disabled", true );
                $( "#editModalModuleTime7" ).prop( "disabled", true );
                $( "#editModalModuleTime8" ).prop( "disabled", true );
                $( "#sendModule").prop( "disabled", true );
            }
            else{
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#editModalModuleTime1" ).prop( "disabled", false );
                $( "#editModalModuleTime2" ).prop( "disabled", false );
                $( "#editModalModuleTime3" ).prop( "disabled", false );
                $( "#editModalModuleTime4" ).prop( "disabled", false );
                $( "#editModalModuleTime5" ).prop( "disabled", false );
                $( "#editModalModuleTime6" ).prop( "disabled", false );
                $( "#editModalModuleTime7" ).prop( "disabled", false );
                $( "#editModalModuleTime8" ).prop( "disabled", false );
            }
        });

        $('#editModalModuleAllTimeLab').on('change',function () {
            var editModalModuleAllTimeTheory = parseInt($('#editModalModuleAllTimeTheory').val());
            var editModalModuleAllTimeLab=parseInt($('#editModalModuleAllTimeLab').val());
            var editModalModuleAllTimeProd=parseInt($('#editModalModuleAllTimeProd').val());
            var AllTime=$('#editModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(editModalModuleAllTimeTheory+editModalModuleAllTimeLab+editModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#editModalModuleTime1" ).prop( "disabled", true );
                $( "#editModalModuleTime2" ).prop( "disabled", true );
                $( "#editModalModuleTime3" ).prop( "disabled", true );
                $( "#editModalModuleTime4" ).prop( "disabled", true );
                $( "#editModalModuleTime5" ).prop( "disabled", true );
                $( "#editModalModuleTime6" ).prop( "disabled", true );
                $( "#editModalModuleTime7" ).prop( "disabled", true );
                $( "#editModalModuleTime8" ).prop( "disabled", true );
                $( "#sendModule").prop( "disabled", true );
            }
            else{
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#editModalModuleTime1" ).prop( "disabled", false );
                $( "#editModalModuleTime2" ).prop( "disabled", false );
                $( "#editModalModuleTime3" ).prop( "disabled", false );
                $( "#editModalModuleTime4" ).prop( "disabled", false );
                $( "#editModalModuleTime5" ).prop( "disabled", false );
                $( "#editModalModuleTime6" ).prop( "disabled", false );
                $( "#editModalModuleTime7" ).prop( "disabled", false );
                $( "#editModalModuleTime8" ).prop( "disabled", false );
            }
        });


        $('#editModalModuleAllTimeProd').on('change',function () {
            var editModalModuleAllTimeTheory = parseInt($('#editModalModuleAllTimeTheory').val());
            var editModalModuleAllTimeLab=parseInt($('#editModalModuleAllTimeLab').val());
            var editModalModuleAllTimeProd=parseInt($('#editModalModuleAllTimeProd').val());
            var AllTime=$('#editModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(editModalModuleAllTimeTheory+editModalModuleAllTimeLab+editModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#editModalModuleTime1" ).prop( "disabled", true );
                $( "#editModalModuleTime2" ).prop( "disabled", true );
                $( "#editModalModuleTime3" ).prop( "disabled", true );
                $( "#editModalModuleTime4" ).prop( "disabled", true );
                $( "#editModalModuleTime5" ).prop( "disabled", true );
                $( "#editModalModuleTime6" ).prop( "disabled", true );
                $( "#editModalModuleTime7" ).prop( "disabled", true );
                $( "#editModalModuleTime8" ).prop( "disabled", true );
                $( "#sendModule").prop( "disabled", true );
            }
            else{
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#editModalModuleTime1" ).prop( "disabled", false );
                $( "#editModalModuleTime2" ).prop( "disabled", false );
                $( "#editModalModuleTime3" ).prop( "disabled", false );
                $( "#editModalModuleTime4" ).prop( "disabled", false );
                $( "#editModalModuleTime5" ).prop( "disabled", false );
                $( "#editModalModuleTime6" ).prop( "disabled", false );
                $( "#editModalModuleTime7" ).prop( "disabled", false );
                $( "#editModalModuleTime8" ).prop( "disabled", false );
            }
        });

        $('#editModalModuleAllTimeNeraspred').on('change',function () {
            if($('#editModalModuleAllTimeNeraspred').val()!=0){
                $('.semEditEdit').prop("disabled", true );

            }
            else{
                $('.semEditEdit').prop("disabled", false );
                $('#sendModule').prop("disabled",false);
            }
        });


        // $('#editModalModuleAllTime').on('keyup',function () {
        //     var addQualModalModuleAllTimeTheory = parseInt($('#addQualModalModuleAllTimeTheory').val());
        //     var addQualModalModuleAllTimeLab=parseInt($('#addQualModalModuleAllTimeLab').val());
        //     var addQualModalModuleAllTimeProd=parseInt($('#addQualModalModuleAllTimeProd').val());
        //     var AllTime=$('#addQualModalModuleAllTime').val();
        //     var AllTimeMinusSumm=parseInt(AllTime-(addQualModalModuleAllTimeTheory+addQualModalModuleAllTimeLab+addQualModalModuleAllTimeProd));
        //     if(AllTimeMinusSumm!=0){
        //         $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
        //         $( ".semEdit" ).prop( "disabled", true );
        //         $( "#sendModule").prop( "disabled", true );
        //     }
        //     else{
        //         $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
        //         $( "#sendModule").prop( "disabled", false );
        //
        //     }
        // });
        $('#editModalModuleAllTime').on('change',function () {
            var editModalModuleAllTimeTheory = parseInt($('#editModalModuleAllTimeTheory').val());
            var editModalModuleAllTimeLab=parseInt($('#editModalModuleAllTimeLab').val());
            var editModalModuleAllTimeProd=parseInt($('#editModalModuleAllTimeProd').val());
            var AllTime=$('#editModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(editModalModuleAllTimeTheory+editModalModuleAllTimeLab+editModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){

                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", true );
                $( "#sendModule").prop( "disabled", true );
            }
            else{
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#sendModule").prop( "disabled", false );

            }
        });

        $('#editModalModuleAllTimeNeraspred').on('change',function () {
            if($('#editModalModuleAllTimeNeraspred').val()==0){
                $( "#sendModule").prop( "disabled", false );
            }
            else{
                $( "#sendModule").prop( "disabled", true );
            }
        });
        $('.semEditEdit').on('keyup',function () {
            var one=parseInt($('#editModalModuleTime1').val());
            var two=parseInt($('#editModalModuleTime2').val());
            var three=parseInt($('#editModalModuleTime3').val());
            var four=parseInt($('#editModalModuleTime4').val());
            var five=parseInt($('#editModalModuleTime5').val());
            var six=parseInt($('#editModalModuleTime6').val());
            var seven=parseInt($('#editModalModuleTime7').val());
            var eight=parseInt($('#editModalModuleTime8').val());
            var allSemEditTimeSumm=parseInt(one+two+three+four+five+six+seven+eight);
            var AllTime=$('#editModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(allSemEditTimeSumm));
            if(AllTimeMinusSumm!=0){
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);


            }
            else{
                $('#editModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#sendModule" ).prop( "disabled", false );
            }

        });

////////////////////////////////////////////////////////////////////////////////////////



        $('#addQualModalModuleAllTimeTheory').on('change',function () {
            var addQualModalModuleAllTimeTheory = parseInt($('#addQualModalModuleAllTimeTheory').val());
            var addQualModalModuleAllTimeLab=parseInt($('#addQualModalModuleAllTimeLab').val());
            var addQualModalModuleAllTimeProd=parseInt($('#addQualModalModuleAllTimeProd').val());
            var AllTime=$('#addQualModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(addQualModalModuleAllTimeTheory+addQualModalModuleAllTimeLab+addQualModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", true );
            }
            else{
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", false );
            }
        });

        $('#addQualModalModuleAllTimeLab').on('change',function () {
            var addQualModalModuleAllTimeTheory = parseInt($('#addQualModalModuleAllTimeTheory').val());
            var addQualModalModuleAllTimeLab=parseInt($('#addQualModalModuleAllTimeLab').val());
            var addQualModalModuleAllTimeProd=parseInt($('#addQualModalModuleAllTimeProd').val());
            var AllTime=$('#addQualModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(addQualModalModuleAllTimeTheory+addQualModalModuleAllTimeLab+addQualModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", true );
            }
            else{
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", false );
            }
        });
        $('#addQualModalModuleAllTimeProd').on('change',function () {
            var addQualModalModuleAllTimeTheory = parseInt($('#addQualModalModuleAllTimeTheory').val());
            var addQualModalModuleAllTimeLab=parseInt($('#addQualModalModuleAllTimeLab').val());
            var addQualModalModuleAllTimeProd=parseInt($('#addQualModalModuleAllTimeProd').val());
            var AllTime=$('#addQualModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(addQualModalModuleAllTimeTheory+addQualModalModuleAllTimeLab+addQualModalModuleAllTimeProd));
            if(AllTimeMinusSumm!=0){
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", true );
            }
            else{
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( ".semEdit" ).prop( "disabled", false );
                var one=parseInt($('#addQualModalModuleTime1').val(0));
                var two=parseInt($('#addQualModalModuleTime2').val(0));
                var three=parseInt($('#addQualModalModuleTime3').val(0));
                var four=parseInt($('#addQualModalModuleTime4').val(0));
                var five=parseInt($('#addQualModalModuleTime5').val(0));
                var six=parseInt($('#addQualModalModuleTime6').val(0));
                var seven=parseInt($('#addQualModalModuleTime7').val(0));
                var eight=parseInt($('#addQualModalModuleTime8').val(0));
            }
        });
        $('.semEdit').on('keyup',function () {
           var one=parseInt($('#addQualModalModuleTime1').val());
           var two=parseInt($('#addQualModalModuleTime2').val());
           var three=parseInt($('#addQualModalModuleTime3').val());
           var four=parseInt($('#addQualModalModuleTime4').val());
           var five=parseInt($('#addQualModalModuleTime5').val());
           var six=parseInt($('#addQualModalModuleTime6').val());
           var seven=parseInt($('#addQualModalModuleTime7').val());
           var eight=parseInt($('#addQualModalModuleTime8').val());
           var allSemEditTimeSumm=parseInt(one+two+three+four+five+six+seven+eight);
            var AllTime=$('#addQualModalModuleAllTime').val();
            var AllTimeMinusSumm=parseInt(AllTime-(allSemEditTimeSumm));
            if(AllTimeMinusSumm!=0){
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);


            }
            else{
                $('#addQualModalModuleAllTimeNeraspred').val(AllTimeMinusSumm);
                $( "#addQualModule" ).prop( "disabled", false );
            }

        });
        $('#addQualModalModuleAllTime').on('keyup',function () {
            $( ".allTimePart" ).prop( "disabled", false );
        });

        function checkFormForAdd() {
            var checkInteger=0;
            var checkBool;
          if ($('#addQualModalModuleModule').val()!=''){
              checkInteger++;
          };
          if($('#addQualModalModuleAllTime').val()!=0){
              checkInteger++;
          };
          if($('#addQualModalModuleAllTimeNeraspred').val()==0){
              checkInteger++;
          };
          if(checkInteger==3){
                checkBool=true;
          }else{checkBool=false};
          return checkBool;
        };

        function checkFormForEdit() {
            var checkInteger=0;
            var checkBool;
          // if($('#editModalModuleModuleIndex').val()!=''){
          //     checkInteger++;
          // };
          if ($('#editModalModuleModule').val()!=''){
              checkInteger++;
          };
          if($('#editModalModuleAllTime').val()!=0){
              checkInteger++;
          };
          // if($('#editModalModuleAllTimeNeraspred').val()==0){
          //     checkInteger++;
          // };
          if(checkInteger==2){
                checkBool=true;
          }else{checkBool=false};
          return checkBool;
        };

        $('.edit_qualBlock').on('click',function (e) {
            e.preventDefault();
            var blockIdEdit=$(this).attr('qualeditbuttonid');
            console.log(blockIdEdit);
            $('#sendQualBlock').addClass('sendBlockButton');
           $('#editModalBodyBlock').html('<div class="form-group field-rupblock-code required"><label class="control-label">Индекс блока:</label>');
           $('#editModalBodyBlock').append('<input type="text" class="form-control" id="editQualCodeModalWindow"></div>');
           $('#editModalBodyBlock').append('<div class="form-group field-rupblock-code required"><label class="control-label">Наименование блока:</label></div>');
           $('#editModalBodyBlock').append('<input type="text" class="form-control" id="editQualNameModalWindow">');
           $('#editModalBodyBlock').append('<div class="form-group field-rupblock-code required"><label class="control-label">Всего часов:</label></div>');
           $('#editModalBodyBlock').append('<input type="text" class="form-control" id="editQualTimeModalWindow">');
           // $('#editModalBodyBlock').append('<div class="form-group field-rupblock-code required" disabled="true"><label class="control-label">Не распределено:</label></div>');
           // $('#editModalBodyBlock').append('<input type="text" class="form-control" id="editQualTimemoduledeductedModalWindow" disabled=true>');
           $('#editQualCodeModalWindow').val($("tr[data-key="+blockIdEdit+"]").attr('data-code'));
           $('#editQualNameModalWindow').val($("tr[data-key="+blockIdEdit+"]").attr('data-name'));
           $('#editQualTimeModalWindow').val($("tr[data-key="+blockIdEdit+"]").attr('data-time'));
           $('#editQualTimemoduledeductedModalWindow').val($("tr[data-key="+blockIdEdit+"]").attr('data-timemodulededucted'));
            $('#editModalBodyBlock').append('<input type="text" class="hidden" id="editQualTimemoduledeductedModalWindowID" value="'+blockIdEdit+'">');
        });

        $('#sendQualBlock').on('click',function (e) {
            e.preventDefault();
            var blockButtonId=$('#editQualTimemoduledeductedModalWindowID').val();
            var code = $('#editQualCodeModalWindow').val();
            var name = $('#editQualNameModalWindow').val();
            var time = $('#editQualTimeModalWindow').val();
            $.ajax({
                type: 'POST',
                url: "/rup/rup-block/update-info?id="+blockButtonId,
                context: document.body,
                data:{'code':code,'name':name,'time':time},
                success: function(data){
                    // console.log(ModalModuleId);
                    location.reload();
                }
            });
            $.ajax({
                type: 'POST',
                url: "/rup/rup-module/update-info?id="+blockButtonId,
                context: document.body,
                data:{'code':code,'name':name,'time':time},
                success: function(data){
                    // console.log(ModalModuleId);
                    location.reload();
                }
            });
            $('#sendQualBlock').removeClass('sendBlockButton');
        });

        //////////Theory zapret na string only integer
        // $('#editModalModuleFormControl1').keypress(function(e)
        // {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
        //     return false;});
        // $('#editModalModuleFormControl2').keypress(function(e)
        // {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
        //     return false;});
        // $('#editModalModuleFormControl3').keypress(function(e)
        // {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
        //     return false;});
        $('.semEditEdit').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#editModalModuleAllTimeTheory').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#editModalModuleAllTimeProd').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#editModalModuleAllTimeLab').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#editModalModuleAllTime').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        ////////////////////////////////////////////////////
        // ////////Theory zapret na string only integer
        // $('#addQualModalModuleFormControl1').keypress(function(e)
        // {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
        //     return false;});
        // $('#addQualModalModuleFormControl2').keypress(function(e)
        // {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
        //     return false;});
        // $('#addQualModalModuleFormControl3').keypress(function(e)
        // {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
        //     return false;});
        $('.semEdit').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#addQualModalModuleAllTimeTheory').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#addQualModalModuleAllTimeProd').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#addQualModalModuleAllTimeLab').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        $('#addQualModalModuleAllTime').keypress(function(e)
        {if(e.which!=8 && e.which!=0 && e.which!=109 && e.which!=188 && e.which!=190 && (e.which<48 || e.which>57))
            return false;});
        ////////////////////////////////////////////////////

    </script>
</div>
    <style>
        body {
            padding-right: 0 !important;
        }
        b{
            padding: 10px;
        }
        tbody tr:hover{
            !important;
            background-color: lightgoldenrodyellow;
        }
        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background-color: lightgoldenrodyellow;
        }

    </style>
</div>