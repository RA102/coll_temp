<?php

use common\models\organization\ReplacementJournal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Журнал ' . $group->caption_current;
?>


<div class="card">
    <div class="card-header">
        <table class="table table-bordered">
            <tr>
                <th class="col-md-4">Группа:</th>
                <td class="col-md-8"><?=$group->caption_current?></td>
            </tr>
            <tr>
                <th>Предмет:</th>
                <td><?=$teacherCourse->disciplineName?></td>
            </tr>
            <tr>
                <th>Преподаватель:</th> 
                <td><?=$teacherCourse->person->getFullname()?> </td>
            </tr>
            <tr>
            	<th>Общее кол-во занятий <br> Проведено <br> Осталось <br> Отмена/замена</th>
            	<td><?=count($dates)?> <br> <?=count($journal)?> <br> <?=count($dates) - count($journal)?> <br> <?=$replaced?> </td>
            </tr>
        </table>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <?= Html::a('Теоретическое обучение', ['view', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Курсовые проекты, лабораторно-практические и графические работы', ['practical', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id], []) ?>
            </li>
            <li role="presentation">
                <?= Html::a('Контрольные работы', ['exam', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id], []) ?>
            </li>
        </ul>
    </div>
    <div class="card-body" style="overflow-x: scroll;">
        <?= Html::a(Yii::t('app', 'Журнал замен'), ['replacement', 'group_id' => $group->id, 'teacher_course_id' => $teacherCourse->id], ['class' => 'btn btn-primary']) ?>
        <table class="table table-bordered table-striped table-responsive">
            <tr>
                <th>№</th>
                <th>ФИО</th>
                <?php foreach ($dates as $key => $date):?>
                    <th <?php if(ReplacementJournal::replaced($group->id, strtotime($date), $teacherCourse->id) == true):?>class="btn-danger"<?php endif;?>>
                        <a title="
                            <?php if($model->ktp !== null):?>
                                <?php if(array_key_exists($key+1 ,$model->ktp)):?>
                                    <?=$model->ktp[$key+1]['lesson_topic']?>
                                <?php endif;?>
                            <?php else:?>
                                тема не указана
                            <?php endif;?>
                                " 
                            href="create?group_id=<?=$group->id?>&date=<?=date('d-m-Y', strtotime($date))?>&teacher_course_id=<?=$teacherCourse->id?>&type=1">
                            <?=date('d.m.y', strtotime($date))?>
                        </a>
                    </th>
                <?php endforeach;?>
            </tr>
            <?php foreach ($group->students as $key=>$student):?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$student->getFullname()?></td>
                    <?php foreach ($dates as $date):?>
                        <?php $attendance = $student->checkAttendance(1, $group->id, $student->id, $teacherCourse->id, date('d.m.y', strtotime($date)));?>
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