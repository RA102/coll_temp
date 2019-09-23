<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Журнал ' . $group->caption_current;
?>


<div class="card">
    <div class="card-header">
        <table class="table table-bordered">
            <tr>
                <th>Группа:</th>
                <td><?=$group->caption_current?></td>
            </tr>
            <tr>
                <th>Предмет:</th>
                <td><?=$teacherCourse->course->institutionDiscipline->caption_current?></td>
            </tr>
            <tr>
                <th>Преподаватель:</th> 
                <td><?=$teacherCourse->person->getFullname()?> </td>
            </tr>
            <tr>
                <th>Начало курса:</th> 
                <td><?=date('d-m-Y', strtotime($teacherCourse->start_ts))?></td>
            </tr>
            <tr>
                <th>Окончание курса:</th> 
                <td><?=date('d-m-Y', strtotime($teacherCourse->end_ts))?></td>
            </tr>
        </table>
        <ul class="nav nav-tabs">
            <li role="presentation">
                <?= Html::a('Теоретическое обучение', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 1], []) ?>
            </li>
            <li role="presentation" class="active">
                <?= Html::a('Курсовые проекты, лабораторно-практические и графические работы', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 2], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Контрольные работы', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 3], []) ?>
            </li>
        </ul>
    </div>
    <div class="card-body" style="overflow-x: scroll;">
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>№</th>
                <th>ФИО</th>
                <?php foreach ($lessons as $lesson):?>
                    <th><a href="create?group_id=<?=$group->id?>&date=<?=date('d.m.y', strtotime($lesson->date_ts))?>&teacher_course_id=<?=$lesson->teacher_course_id?>&type=2"><?=date('d.m.y', strtotime($lesson->date_ts))?></a></th>
                <?php endforeach;?>
            </tr>
            <?php foreach ($group->students as $key=>$student):?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$student->getFullname()?></td>
                    <?php foreach ($lessons as $lesson):?>
                        <?php $attendance = $student->checkAttendance(2, $group->id, $student->id, $teacherCourse->id, date('d.m.y', strtotime($lesson->date_ts)));?>
                        <?php if ($attendance[0] == 1):?>
                            <td class="btn-danger">н/б</td>
                        <?php elseif ($attendance[0] == 2):?>
                            <td class="btn-warning">н/у</td>
                        <?php elseif ($attendance[0] == 3):?>
                            <td class=""><?=$attendance[1]?></td>
                        <?php else:?>
                            <td></td>
                        <?php endif;?>
                    <?php endforeach;?>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>