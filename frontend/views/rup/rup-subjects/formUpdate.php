<?php

use frontend\models\rup\RupSubjects;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

?>
<!--<form id="addQualification">-->
<?php $form = ActiveForm::begin(['id' => 'addQualification']); ?>
    <div class="row">
        <div class="col-3" style="font-weight:bold">Модуль/Дисциплина:</div>
        <div class="col-2">
            <input class="form-control" id="addQualModalModuleModuleIndex" type="text" placeholder="индекс"></div>
        <div class="col-5">


            <?= $form->field($dataProviderSubject, 'name')->label(false)->dropDownList($listData,
                ['prompt' => 'Выберите шаблон', 'class' => 'form-control', 'id' => 'addQualModalModuleModule']);
            ?>

        </div>

        <div class="col-2">
            <?php
            Modal::begin([
                'id' => 'subModal',
                'size' => 'modal-sm',
                'toggleButton' => ['label' => 'Добавить', 'class' => 'btn btn-success', 'id' => 'addDiscipline'],
            ]);

            echo $this->renderAjax('/rup/rup-subjects/create',['model'=> $Model=new RupSubjects()]);

            Modal::end();
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-3">Входит в модуль:</div>
        <div class="col-9">
            <input class="form-control" id="addQualModalModuleInModule" type="text" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-3" style="font-weight:bold">Форма контроля:</div>
        <div class="col-3">Экзамен: <input class="form-control"
                                           id="addQualModalModuleFormControl1" type=""
                                           maxlength="6"></div>
        <div class="col-3">Зачет: <input class="form-control"
                                         id="addQualModalModuleFormControl2" type=""
                                         maxlength="6"></div>
        <div class="col-3">Контрольная: <input class="form-control"
                                               id="addQualModalModuleFormControl3" type=""
                                               maxlength="6"></div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-3" style="font-weight:bold">Часов для распределения:</div>
        <div class="col-3" style="font-weight:bold">Всего:
            <input class="form-control" id="addQualModalModuleAllTime" type="number">
        </div>
        <div class="col-3"></div>
        <div class="col-3" style="font-weight:bold">Не распределено:
            <input class="form-control" id="addQualModalModuleAllTimeNeraspred" type="text" disabled="true">
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-3" style="font-weight:bold">Объем учебного времени:</div>
        <div class="col-3">Теоретическое:
            <input class="form-control allTimePart" id="addQualModalModuleAllTimeTheory" type="number" value="0">
        </div>
        <div class="col-3">Лаб.-практическое:
            <input class="form-control allTimePart" id="addQualModalModuleAllTimeLab" type="number" value="0">
        </div>
        <div class="col-3">Производственное:
            <input class="form-control allTimePart" id="addQualModalModuleAllTimeProd" type="number" value="0">
        </div>
    </div>

    <div class="row">
        <div class="col-12" style="font-weight:bold">Время по семестрам:</div>
    </div>

    <div class="row">
        <div class="col-3"></div>
        <div class="col-1">1 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime1"
                                  type="number" value="0"></div>

        <div class="col-1">2 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime2"
                                  type="number" value="0"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-1">3 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime3"
                                  type="number" value="0"></div>

        <div class="col-1">4 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime4"
                                  type="number" value="0"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-1">5 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime5"
                                  type="number" value="0"></div>

        <div class="col-1">6 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime6"
                                  type="number" value="0"></div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-1">7 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime7"
                                  type="number" value="0"></div>

        <div class="col-1">8 сем:</div>
        <div class="col-2"><input class="form-control semEdit" id="addQualModalModuleTime8"
                                  type="number" value="0"></div>
    </div>

    <br>


    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
    <input type="text" class="hidden" id="moduleAppendId">
    <input type="submit" class="btn btn-primary" id="addQualModule" value="Добавить"
           disabled="true"></input>
<?php ActiveForm::end(); ?>
