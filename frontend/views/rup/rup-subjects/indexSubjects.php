<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="utf-8" />-->
<!--    <title>HTML5</title>-->
<!--    <!--[if IE]>-->
<!--    <![endif]-->-->
<!--</head>-->
<!--<body>-->
<table  class="table table-striped  table-bordered " >
    <tr>
        <th  >Модуль</th>
        <th  >Квалификация</th>
        <th >Часы всего</th>
        <th  >Часы нераспред.</th>
    </tr>
    <?php
    foreach ($all as $al){
        $time=$al['time']-($al['teory_time']+$al['lab_time']+$al['production_practice_time']);
        ?>
        <tr id="<?= $al['id'] ?>" class='ChangeClickRow' >
            <td><?= $al['subBlock']['code']-$al['subBlock']['name']?></td>
<td  ><?= $al['name'] ?></td>
<td  ><?=$al['time']?></td>
<td  ><?=$time?></td>
<td>
<button style='margin-left:15%; margin-top: 1%;margin-bottom: 1%;' class='btn btn-danger delete_qual' id="<?= $id ?>">
    <span class='glyphicon glyphicon-trash'>
</button>
    <button style='margin-left:10%;' class='btn btn-success edit_qual' id="<?= $id ?>">
        <h7><i class='fas fa-edit'></i></h7>
    </button>
</td></tr><?php
    }

    ?>
</table>
<script>
    console.log(1);
    $('.ChangeClickRow').on('click',function (e) {
        alert()
        alert(this.id);
    })
</script>
<!--</body>-->
<!--</html>-->