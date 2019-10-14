<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал ' . $group->caption_current;
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="position: relative;">
    <h1><?= Html::encode($this->title) ?></h1>
    <!-- <?= Html::a('Добавить', ['create', 'group_id' => $group->id], ['class' => 'title-action btn btn-primary']) ?> -->
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Предмет</th>
                <th>Преподаватель</th>
                <th>Тип</th>
            </tr>
            <?php foreach ($teacherCourses as $teacherCourse):?>
                <tr>
                    <td><?= Html::a($teacherCourse->disciplineName, ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 1], ['class' => '']) ?>                        
                    </td>
                    <td><?=$teacherCourse->person->getFullname()?></td>
                    <td><?=$teacherCourse->statusName?></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
