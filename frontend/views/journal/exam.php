<?php

use common\models\organization\ReplacementJournal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Журнал ' . $group->caption_current;
?>

<div style="position: relative;">
    <h1><?=$this->title?></h1>
    <?= Html::a(Yii::t('app', 'Журнал замен'), ['replacement', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id], ['class' => 'title-action btn btn-primary']) ?>
</div>
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
        </table>
        <ul class="nav nav-tabs">
            <li role="presentation">
                <?= Html::a('Теоретическое обучение', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 1], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Курсовые проекты, лабораторно-практические и графические работы', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 2], []) ?>
            </li>
            <li role="presentation" class="active">
                <?= Html::a('Контрольные работы', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id, 'type' => 3], []) ?>
            </li>
        </ul>
    </div>
    <div class="card-body" style="overflow-x: scroll;">
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>№</th>
                <th>ФИО</th>
                <?php foreach ($dates as $key => $date):?>
                    <th <?php if(ReplacementJournal::replaced($group->id, strtotime($date), $teacherCourse->id) == true):?>class="btn-danger"<?php endif;?>>
                        <a href="create?group_id=<?=$group->id?>&date=<?=date('d-m-Y', strtotime($date))?>&teacher_course_id=<?=$teacherCourse->id?>&type=3">
                            <?=date('d.m.y', strtotime($date))?> <br>
                            <?php foreach ($exams as $key2 => $value) :?>
                                <?php if($key==$key2):?>
                                    <?=$value['lesson_topic']?>
                                <?php endif;?>
                            <?php endforeach;?>
                        </a>
                    </th>
                <?php endforeach;?>
            </tr>
            <?php foreach ($group->students as $key=>$student):?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$student->getFullname()?></td>
                    <?php foreach ($dates as $date):?>
                        <?php $attendance = $student->checkAttendance($type, $group->id, $student->id, $teacherCourse->id, date('d.m.y', strtotime($date)));?>
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