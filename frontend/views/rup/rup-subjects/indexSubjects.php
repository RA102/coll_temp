
<table  class="table table-striped  table-bordered " >
    <tr>
        <th>№</th>
        <th>Индекс</th>
        <th>Дисциплина</th>
        <th>Часы всего</th>
        <th>Часы нераспред.</th>
<!--        <th><button moduleId="--><?php //echo $module_ID?><!--" title='Добавить' style='margin-left:10%;' data-target="#addModalModule" data-toggle="modal" class='btn btn-success edit_qual addQualModuleButton' idd="--><?//= $al['id'] ?><!--">-->
<!--                <h7>Добавить</h7>-->
<!--            </button></th>-->
    </tr>
    <?php

    use frontend\models\rup\RupBlock;
    use frontend\models\rup\RupSubjects;
    use yii\bootstrap\Modal;

    $i=1;
    foreach ($all as $al){
        $time=$al['time']-($al['teory_time']+$al['lab_time']+$al['production_practice_time']);
        ?>
        <tr id="<?= $al['id'] ?>" class='' >
            <td><?= $i;?></td>
<td  ><?= $al['code'] ?></td>
<td  ><?= $al['name'] ?></td>
<td  ><?=$al['time']?></td>
<td  ><?=$time?></td>
<td  ><?php
//    Modal::begin([
//        'header' => '<h2>Добавить модуль</h2>',
//        'toggleButton' => [
//            'label' => 'Добавить блок',
//            'class' => 'btn btn-success',
//            'style' => ['margin-top' => '5px;']
//        ],
//
//
//    ]);
//
//    echo $this->renderAjax('/rup/rup-subject/_form', ['model' => $Model = new RupSubjects()]);
//
//    Modal::end(); ?><!--</td>-->
<td>
    <button title='Изменить' style='margin-left:10%;' data-target="#editModalModule" data-toggle="modal" class='btn btn-success edit_qual updateModuleButton' idd="<?= $al['id'] ?>">
        <h7><i class='fas fa-edit'></i></h7>
    </button>
            <button title='Удалить' style='margin-left:15%; margin-top: 1%;margin-bottom: 1%;' class='btn btn-danger delete_Module' idd="<?= $al['id'] ?>">
    <span class='glyphicon glyphicon-trash'>
            </button>

</td></tr><?php
    $i++;}

    ?>
</table>
<script>
    $('.updateModuleButton').on('click',function () {
        var a = $(this).attr('idd');
        $('#editModalModuleFormControl1').prop('disabled',true);
        $('#editModalModuleFormControl2').prop('disabled',true);
        $('#editModalModuleFormControl3').prop('disabled',true);
        $('#editModalModuleAllTimeTheory').prop('disabled',true);
        $('#editModalModuleAllTimeLab').prop('disabled',true);
        $('#editModalModuleAllTimeProd').prop('disabled',true);
        $('#editModalModuleAllTime').prop('disabled',true);
        $('.semEditEdit').prop('disabled',true);
        $.ajax({
            url: '/rup/rup-subjects/get-info?id='+a,
            success: function(data){
                $('#editModalModuleModule').val(data.name);
                $('#editModalModuleModuleIndex').val(data.code);
                $('#editModalModuleInModule').val(data.id_sub_block);
                $('#editModalModuleInModule').val(data.id_sub_block);
                $('#editModalModuleFormControl1').val(data.exam);
                $('#editModalModuleFormControl2').val(data.offset);
                $('#editModalModuleFormControl3').val(data.control_work);
                $('#editModalModuleAllTime').val(data.time);
                $('#editModalModuleAllTimeNeraspred').val(data.time);
                $('#editModalModuleAllTimeTheory').val(data.teory_time);
                $('#editModalModuleAllTimeLab').val(data.lab_time);
                $('#editModalModuleAllTimeProd').val(data.production_practice_time);
                $('#editModalModuleTime1').val(data.one_sem_time);
                $('#editModalModuleTime2').val(data.two_sem_time);
                $('#editModalModuleTime3').val(data.three_sem_time);
                $('#editModalModuleTime4').val(data.four_sem_time);
                $('#editModalModuleTime5').val(data.five_sem_time);
                $('#editModalModuleTime6').val(data.six_sem_time);
                $('#editModalModuleTime7').val(data.seven_sem_time);
                $('#editModalModuleTime8').val(data.eight_sem_time);
                $('#editModalID').val(a);
                $('#editModalModuleFormControl1').prop('disabled',false);
                $('#editModalModuleFormControl2').prop('disabled',false);
                $('#editModalModuleFormControl3').prop('disabled',false);
                $('#editModalModuleAllTimeTheory').prop('disabled',false);
                $('#editModalModuleAllTimeLab').prop('disabled',false);
                $('#editModalModuleAllTimeProd').prop('disabled',false);
                $('#editModalModuleAllTime').prop('disabled',false);
                $('.semEditEdit').prop('disabled',false);
            }
        });

    });
    $('.delete_Module').on('click',function () {
        var a = $(this).attr('idd');

        $.ajax({
            url: '/rup/rup-subjects/delete-module?id='+a,
            success: function(data){
                location.reload();
                // console.log(data.lab_time);
            }
        });

    });
</script>
<!--</body>-->
<!--</html>-->