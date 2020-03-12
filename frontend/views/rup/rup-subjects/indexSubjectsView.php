
<table  class="table table-striped  table-bordered " >
    <tr>
        <th>№</th>
        <th>Дисциплина</th>
        <th>Часы всего</th>
        <th>Часы нераспред.</th>
    </tr>
    <?php
    $i=1;
    foreach ($all as $al){
        $time=$al['time']-($al['teory_time']+$al['lab_time']+$al['production_practice_time']);
        ?>
        <tr id="<?= $al['id'] ?>" class='' >
            <td><?= $i;?></td>
<td  ><?= $al['name'] ?></td>
<td  ><?=$al['time']?></td>
<td  ><?=$time?></td>
</tr><?php
    $i++;}

    ?>
</table>
<script>
    $('.updateModuleButton').on('click',function () {
        var a = $(this).attr('idd');

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
                $('#editModalModuleAllTimeNeraspred').val('СДЕЛАЙ ВРЕМЯ');
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

                console.log(data.lab_time);
            }
        });

    });
    $('.delete_Module').on('click',function () {
        var a = $(this).attr('idd');
        if (confirm('Вы действительно хотите удалить?')) {
            $.ajax({
                url: '/rup/rup-subjects/delete-module?id='+a,
                success: function(data){
                    var url= "/rup/rup/update?id="+$('#ruproots-rup_id').val()+"&active=2";
                    window.location = url;
                    // console.log(data.lab_time);
                }
            });
        } else {
        }


    });
</script>
<!--</body>-->
<!--</html>-->