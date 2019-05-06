<?php

use common\helpers\ReceptionExamGradeHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $receptionGroup common\models\ReceptionGroup */
/* @var $receptionExams common\models\ReceptionExam[] */
/* @var $entrants common\models\person\Entrant[] */
/* @var $gradeMap \common\models\ReceptionExamGrade[][] */

$this->title = Yii::t('app', 'Reception Exam Grades');
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <td></td>
                <?php foreach ($receptionExams as $receptionExam): ?>
                    <td><?= $receptionExam->getFullName() ?></td>
                <?php endforeach; ?>
                <td>Итог</td>
            </tr>
            </thead>
            <?php foreach ($entrants as $entrant): ?>
                <tr>
                    <?php $total = 0; ?>
                    <td><?= $entrant->getFullName() ?></td>
                    <?php foreach ($receptionExams as $receptionExam): ?>
                        <td>
                            <a href="<?= \yii\helpers\Url::to([
                                'reception-exam-grade/create',
                                'reception_group_id' => $receptionGroup->id,
                                'entrant_id' => $entrant->id,
                                'exam_id' => $receptionExam->id,
                            ]) ?>" target="_self"><span class="glyphicon glyphicon-pencil"></span></a>
                            &nbsp;
                            <?php if (isset($gradeMap[$entrant->id][$receptionExam->id])): ?>
                                <?php
                                    $receptionExamGrade = $gradeMap[$entrant->id][$receptionExam->id];
                                    $total += ReceptionExamGradeHelper::getGradeTypePoints($receptionExamGrade->grade_type)[$receptionExamGrade->grade];
                                    echo ReceptionExamGradeHelper::getGradeTypeLabels($receptionExamGrade->grade_type)[$receptionExamGrade->grade] ?? '';
                                ?>
                            <?php endif ?>
                        </td>
                    <?php endforeach; ?>
                    <td><?= $total ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>